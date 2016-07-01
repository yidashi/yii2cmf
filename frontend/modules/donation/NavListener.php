<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 下午12:00
 */

namespace frontend\modules\donation;


class NavListener
{
    public static function handle($event)
    {
        //加到左边导航上
        $event->sender->params['menuItems'][] = ['label' => '捐赠', 'url' => ['/donation']];
    }
}