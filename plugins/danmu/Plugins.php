<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:43
 */

namespace plugins\danmu;


use yii\base\BootstrapInterface;
use yii\web\View;
use yii\base\Event;
use plugins\danmu\controllers\DefaultController;

class Plugins extends \plugins\Plugins implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'danmu',
        'name' => '弹幕',
        'description' => '文章评论弹幕'
    ];

    public function frontend($app)
    {
        Event::on(View::className(), 'afterComment', ['plugins\danmu\Danmu', 'handle']);
        $app->controllerMap['danmu'] = [
            'class' => DefaultController::className(),
        ];
    }

}