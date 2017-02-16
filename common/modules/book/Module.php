<?php

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/2/16
 * Time: 下午9:32
 */

namespace common\modules\book;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app->id == 'app-backend') {
            $app->urlManager->addRules([
                'book/<action:\S+>' => 'book/admin/<action>',
            ], false);
        } else if ($app->id == 'app-frontend') {
            $app->urlManager->addRules([
                'books' => '/book/default/index',
                'book/<id:\d+>' => '/book/default/view',
                'book/chapter/<id:\d>' => '/book/default/chapter',
                'book/<action:\S+>' => 'book/default/<action>',
            ], false);
        }
    }
}