<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/6
 * Time: 下午5:48
 */

namespace frontend\widgets\reward;


use common\models\Article;
use common\models\Reward;
use yii\base\Exception;
use yii\base\Model;

class RewardForm extends Model
{
    public $article_id;
    public $money;
    public $comment;

    public function rules()
    {
        $rules = [
            [['article_id', 'money'], 'required'],
            ['comment', 'string', 'max' => 255],
            ['money', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => '打赏额必须大于0'],
        ];
        if (!\Yii::$app->user->isGuest) {
            $rules[] = ['money', 'compare', 'compareValue' => \Yii::$app->user->identity->profile->money, 'operator' => '<=', 'message' => '打赏额不能大于自身账户余额'];
            $rules[] = ['article_id', 'checkIsAuthor'];
        }
        return $rules;
    }

    public function checkIsAuthor($attribute)
    {
        $article = Article::findOne($this->$attribute);
        if ($article == null) {
            $this->addError($attribute, '文章不存在');
            return false;
        }
        if ($article->user_id == \Yii::$app->user->id) {
            $this->addError($attribute, '不能给自己的文章打赏');
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
                $article = Article::find()->where(['id' => $this->article_id])->one();
                $article->user->profile->updateCounters(['money' => $this->money]);
                $reward = new Reward();
                $reward->article_id = $this->article_id;
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