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
use yii\validators\InlineValidator;

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
            ['money', 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => '打赏额必须大于0'],
            ['money', 'compare', 'compareValue' => \Yii::$app->user->identity->profile->money, 'operator' => '<', 'message' => '打赏额不能大于自身账户余额'],
        ];
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