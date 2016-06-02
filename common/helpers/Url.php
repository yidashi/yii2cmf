<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 下午12:56
 */

namespace common\helpers;


class Url extends \yii\helpers\Url
{
    public static function img($src)
    {
        $src = Url::to($src);
        if (strpos($src, 'http') === false) {
            $src = \Yii::getAlias('@static') . '/' . $src;
        }
        return $src;
    }
}