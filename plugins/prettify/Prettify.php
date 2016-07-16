<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午3:35
 */

namespace plugins\prettify;


class Prettify
{
    public static function handle($event)
    {
        echo PrettifyWidget::widget();
    }
}