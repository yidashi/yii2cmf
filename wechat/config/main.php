<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'app-wechat',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \common\components\LoadPlugins::className(),
    ],
    'controllerNamespace' => 'wechat\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/<mpId:\d+>' => '/',
            ],
        ],
        'request' => [
            'parsers' => [
                'application/xml' => 'wechat\components\XmlParser',
                'text/xml' => 'wechat\components\XmlParser'
            ]
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_XML => [
                    'class' => 'yii\web\XmlResponseFormatter',
                    'rootTag' => 'xml'
                ]
            ]
        ],
        'pluginManager' => [
            'class' => 'common\components\PluginManager',
        ],
    ],
    'params' => $params,
];
