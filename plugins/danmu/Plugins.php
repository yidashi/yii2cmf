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

class Plugins extends \plugins\Plugins implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'name' => 'danmu',
        'title' => '弹幕',
        'desc' => '文章评论弹幕'
    ];

    public function bootstrap($app)
    {
        $app->events->addListener(View::className(), 'afterArticleView', 'plugins\danmu\Danmu');
    }

}