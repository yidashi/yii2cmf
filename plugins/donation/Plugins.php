<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午1:46
 */

namespace plugins\donation;


use yii\base\BootstrapInterface;
use yii\web\View;

class Plugins extends \plugins\Plugins implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'name' => 'donation',
        'title' => '捐赠',
        'desc' => '捐赠模块'
    ];

    public function bootstrap($app)
    {
        $app->events->addListener(View::className(), 'leftNav', 'plugins\donation\NavListener');
    }
}