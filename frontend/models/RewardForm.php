<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/6
 * Time: 下午5:48
 */

namespace frontend\models;


use common\models\Reward;
use yii\base\Model;

class RewardForm extends Model
{
    public $article_id;
    public $money;
    public $comment;

    public function rules()
    {
        return [
            [['article_id', 'money'], 'required'],
            ['comment', 'string', 'max' => 255],
            ['money', 'validateMoney']
        ];
    }

    public function validateMoney($attribute, $params)
    {
        if ($this->$attribute <= 0) {
            $this->addError($attribute, '打赏金额必须大于0');
            return false;
        }
        if ($this->$attribute > \Yii::$app->user->identity->profile->money) {
            $this->addError($attribute, '打赏金额不能超过帐号余额');
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
            'money' => '(帐号余额:' . \Yii::$app->user->identity->profile->money . ')'
        ];
    }

    public function reward()
    {
        if ($this->validate()) {
            $reward = new Reward();
            $reward->article_id = $this->article_id;
            $reward->money = $this->money;
            if($reward->save() !== false) {
                return true;
            }
        }
        return false;
    }
}