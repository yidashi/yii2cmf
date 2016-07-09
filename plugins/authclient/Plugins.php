<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/9
 * Time: 下午11:02
 */

namespace plugins\authclient;


use yii\web\View;

class Plugins extends \plugins\Plugins
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'name' => 'authclient',
        'title' => '第三方登录',
        'desc' => '第三方登录插件'
    ];

    public function frontend($app)
    {
        $app->events->addListener(View::className(), 'afterLogin', 'plugins\authclient\AfterLoginListener');
        $app->set('authClientCollection', [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'plugins\authclient\clients\QqOAuth',
                    'clientId' => env('QQ_CLIENT_ID'),
                    'clientSecret' => env('QQ_CLIENT_SECRET')
                ],
            ]
        ]);
        $app->controllerMap['auth'] = [
            'class' => AuthController::className()
        ];
    }

}