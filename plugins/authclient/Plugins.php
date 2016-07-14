<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/9
 * Time: 下午11:02
 */

namespace plugins\authclient;


use yii\authclient\clients\GitHub;
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
        $config = $this->getConfig();
        $params = [
            'qq' => [
                'class' => 'plugins\authclient\clients\QqOAuth',
                'clientId' => $config['QQ_CLIENT_ID'],
                'clientSecret' => $config['QQ_CLIENT_SECRET']
            ],
            'github' => [
                'class' => GitHub::className(),
                'clientId' => $config['GITHUB_CLIENT_ID'],
                'clientSecret' => $config['GITHUB_CLIENT_SECRET']
            ],
        ];
        $openClients = $config['OPEN_AUTHCLIENT'];
        $openParams = [];
        if (!empty($openClients)) {
            foreach ($openClients as $client) {
                $client = strtolower($client);
                $openParams[$client] = $params[$client];
            }
        }
        $app->set('authClientCollection', [
            'class' => 'yii\authclient\Collection',
            'clients' => $openParams
        ]);
        $app->controllerMap['auth'] = [
            'class' => AuthController::className()
        ];
    }

}