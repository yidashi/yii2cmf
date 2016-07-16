<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        \common\components\LoadPlugins::className(),
        'events'
    ],
    'controllerMap'=>[
        'file-manager-elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@static',
                    'basePath' => '@staticroot',
                    'path'   => '/',
                ]
            ]
        ],
        'upload' => \common\actions\UploadController::className()
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__idBackend',
            'identityCookie' => ['name' => '_identityBackend', 'httpOnly' => true]
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'booleanFormat' => ['<i class="fa fa-times"></i>', '<i class="fa fa-check"></i>']
        ],
        'i18n' => [
            'translations' => [
                'kvgrid' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@kvgrid/messages',
                    'forceTranslation' => true,
                ],
                'yii2tech-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2tech/admin/messages',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'events' => \backend\components\Events::className()
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'database' => [
            'class' => 'backup\Module'
        ]
    ],
    'aliases' => [
        '@mdm/admin' => '@backend/modules/rbac',
        '@backup' => '@backend/modules/backup',
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/logout',
        ],
    ],
    'params' => $params,
];
