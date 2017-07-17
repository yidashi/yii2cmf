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
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}