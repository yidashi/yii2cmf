<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/1
 * Time: 下午6:28
 */

namespace common\helpers;


use rmrevin\yii\fontawesome\FA;

class Html extends \yii\helpers\Html
{
    public static function icon($name, $options = [])
    {
        return FA::i($name, $options);
    }
}