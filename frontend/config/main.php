<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-frontend',
    'name' => '饮水思源',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n'=>[
            'translations' => [
                'app'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'forceTranslation' => true
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                'article/<cid:\d+>' => 'article/index'
                /*[
                    'pattern'=>'lizhi',
                    'route'=>'article/index',
                    'defaults'=>['cid'=>1]
                ]*/
            ]
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/special',
                        '@app/themes/basic',
                    ]
                ],
            ],
//            'as ThemeBehavior' => \frontend\components\ThemeBehavior::className()
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'yii\authclient\clients\QqOAuth',
                    'clientId' => '101277194',
                    'clientSecret' => '11ce53c8fb7daadcc246805727bb6fdb',
              ],
                // etc.
            ],
        ]
    ],
    'params' => $params,
];
