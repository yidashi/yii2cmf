<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/6
 * Time: 下午5:48
 */

namespace frontend\models;


use yii\base\Model;

class RewardForm extends Model
{
    public $article_id;
    public $user_id;
    public $money;
    public $comment;

    public function rules()
    {
        return [
            [['article_id', 'user_id', 'money'], 'required'],
            ['comment', 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'money' => '金额',
            'comment' => '留言'
        ];
    }
}