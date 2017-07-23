<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/13 9:54
 * Description:
 */

namespace common\helpers;


use yii\helpers\BaseStringHelper;

class StringHelper extends BaseStringHelper
{
    public static function random($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}