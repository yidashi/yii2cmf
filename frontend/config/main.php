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
        'common\\components\\LoadPlugins',
        'common\\components\\LoadModule'
    ],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'upload' => \common\actions\UploadController::className()
    ],
    'components' => [
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
                    'sourcePath' => '@frontend/components/bootstrap/dist',
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                        YII_ENV_DEV ? 'css/bootstrap-theme.css' : 'css/bootstrap-theme.min.css'
                    ]
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
        'search' => [
            'class' => 'frontend\\components\\Search',
            'engine' => env('SEARCH_ENGINE', 'local')
        ]
    ],
    'as ThemeBehavior' => \frontend\behaviors\ThemeBehavior::className(),
    'as RouteBehavior' => \frontend\behaviors\RouteBehavior::className(),
    'params' => $params,
];
