<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午1:46
 */

namespace plugins\code;


use yii\base\BootstrapInterface;
use yii\web\View;

class Plugins extends \plugins\Plugins implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'name' => 'code',
        'title' => '获取源码',
        'desc' => '获取源码'
    ];

    public function bootstrap($app)
    {
        $app->events->addListener(View::className(), 'leftNav', 'plugins\code\NavListener');
        $app->events->addListener(View::className(), 'indexSideBar', 'plugins\code\SideBarListener');
    }

}