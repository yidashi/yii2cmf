<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/6
 * Time: 下午5:48
 */

namespace frontend\widgets\reward;


use common\modules\document\models\Document;
use common\models\Reward;
use yii\base\Exception;
use yii\base\Model;

class RewardForm extends Model
{
    public $document_id;
    public $money;
    public $comment;

    public function rules()
    {
        $rules = [
            [['document_id', 'money'], 'required'],
            ['comment', 'string', 'max' => 255],
            ['money', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => '打赏额必须大于0'],
        ];
        if (!\Yii::$app->user->isGuest) {
            $rules[] = ['money', 'compare', 'compareValue' => \Yii::$app->user->identity->profile->money, 'operator' => '<=', 'message' => '打赏额不能大于自身账户余额'];
            $rules[] = ['document_id', 'checkIsAuthor'];
        }
        return $rules;
    }

    public function checkIsAuthor($attribute)
    {
        $document = Document::findOne($this->$attribute);
        if ($document == null) {
            $this->addError($attribute, '内容不存在');
            return false;
        }
        if ($document->user_id == \Yii::$app->user->id) {
            $this->addError($attribute, '不能给自己的内容打赏');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return [
            'money' => '金额',
            'comment' => '留言'
        ];
    }

    public function attributeHints()
    {
        return [
            'money' => '(帐号余额:' . \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->profile->money . ')'
        ];
    }

    public function reward()
    {
        if ($this->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                // 打赏者扣钱
                /* @var $profile \common\modules\user\models\Profile */
                $profile = \Yii::$app->user->identity->profile;
                $result = $profile::getDb()->createCommand('update {{%profile}} set money=money-' . $this->money . ' WHERE user_id = ' . $profile->user_id . ' AND money>=' . $this->money)->execute();
                if ($result == 0) {
                    throw new Exception('打赏失败');
                }
                // 作者加钱
                $document = Document::find()->where(['id' => $this->document_id])->one();
                $document->user->profile->updateCounters(['money' => $this->money]);
                $reward = new Reward();
                $reward->document_id = $this->document_id;
                $reward->money = $this->money;
                $reward->comment = $this->comment;
                if($reward->save() === false) {
                    throw new Exception('打赏失败');
                }
                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollback();
                return false;
            }
        }
    }
}