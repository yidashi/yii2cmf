<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/8
 * Time: 下午11:21
 */

namespace api\modules\v1\models;


use api\common\models\User;
use yii\helpers\ArrayHelper;

class Comment extends \common\models\Comment
{
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'author',
        ]);
    }

    public function extraFields()
    {
        return [
            'sons'
        ];
    }
}