<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\common\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/article',
                        'v1/nav'
                    ]
                ],
            ],
        ],
        'response' => [
            'on afterSend' => function($event) {
            }
        ]
    ],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => api\modules\v1\Module::className()
        ],
        'v2' => [
            'basePath' => '@api/modules/v2',
        ],
    ],
    'params' => $params
];
