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
    public function wechat($app)
    {
        $app->events->addListener('yii\web\Controller','afterAction', 'plugins\wxreply\ReplyListener');
    }

}