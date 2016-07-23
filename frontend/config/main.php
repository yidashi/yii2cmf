<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \common\components\LoadPlugins::className(),
        'events'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'upload' => \common\actions\UploadController::className()
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'on afterLogin' => function($event) {
                $event->identity->touch('login_at');
            }
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@frontend/components/bootstrap/dist'
                ],
            ],
        ],
        'view' => [
            'on beginPage' => function($event){
                if ($event->sender->title) {
                    $event->sender->title .= ' - ' . \Yii::$app->config->get('SITE_NAME');
                } else {
                    $event->sender->title = \Yii::$app->config->get('SITE_NAME');
                }
            }
        ],
        'pluginManager' => [
            'class' => 'common\components\PluginManager',
        ],
        'notify' => \frontend\components\notify\Handler::className(),
        'events' => \frontend\components\Events::className()
    ],
    'as ThemeBehavior' => \frontend\behaviors\ThemeBehavior::className(),
    'as RouteBehavior' => \frontend\behaviors\RouteBehavior::className(),
    'params' => $params,
];
