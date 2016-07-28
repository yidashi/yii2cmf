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
    ],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'upload' => \common\actions\UploadController::className()
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'loginUrl' => '/user/security/login',
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap' => ['app' => 'frontend.php'],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
            ]
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
        'search' => [
            'class' => 'frontend\\components\\Search',
            'engine' => env('SEARCH_ENGINE', 'local')
        ]
    ],
    'modules' => [
        'user' => [
            'as frontend' => 'common\modules\user\filters\FrontendFilter',
        ]
    ],
    'as ThemeBehavior' => \frontend\behaviors\ThemeBehavior::className(),
    'as RouteBehavior' => \frontend\behaviors\RouteBehavior::className(),
    'params' => $params,
];
