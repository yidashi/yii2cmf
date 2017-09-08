<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
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
        'assetManager' => [
            'bundles' => require(__DIR__ . '/' . (YII_ENV_PROD ? 'assets-prod.php' : 'assets-dev.php')),
        ],
        'search' => [
            'class' => 'frontend\\components\\Search',
            'engine' => env('SEARCH_ENGINE', 'local')
        ]
    ],
    'as notify' => \common\behaviors\NotifyBehavior::className(),
    'params' => $params,
];
