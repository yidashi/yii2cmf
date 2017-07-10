<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午3:35
 */

namespace plugins\wxfollow;


use yii\base\Event;

class Plugin extends \plugins\Plugin
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'wxfollow',
        'name' => '微信关注取关',
        'description' => '微信关注取关'
    ];

    public function wechat($app)
    {
        $config = $this->getConfig();
        Event::on('yii\web\Controller','afterAction', ['plugins\wxfollow\FollowListener', 'handle'], $config);
    }

}