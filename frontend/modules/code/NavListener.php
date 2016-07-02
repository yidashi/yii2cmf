<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 下午12:00
 */

namespace frontend\modules\code;


class NavListener
{
    public static function handle($event)
    {
        //加到左边导航上
        $event->sender->params['menuItems'][] = [
            'label' => '获取源码',
            'url' => ['/code'],
            'active' => \Yii::$app->controller->getRoute() == 'code/default/index'
        ];
    }
}