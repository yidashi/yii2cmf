<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/8 17:34
 * Description:
 */

namespace api\modules\v1\models;


use api\common\models\User;

class Notify extends \common\models\Notify
{
    public function fields()
    {
        return [
            'from',
            'to',
            'title'
        ];
    }

    public function extraFields()
    {
        return [
            'content',
        ];
    }

    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_uid']);
    }

    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_uid']);
    }
}