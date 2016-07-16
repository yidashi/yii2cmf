<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午3:35
 */

namespace plugins\wxreply;


class Plugins extends \plugins\Plugins
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'name' => 'wxreply',
        'title' => '微信自动回复',
        'desc' => '微信自动回复'
    ];

    public function wechat($app)
    {
        $app->events->addListener('yii\web\Controller','afterAction', 'plugins\wxreply\ReplyListener');
    }

}