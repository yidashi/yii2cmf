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
        \backend\components\Events::className()
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
        ]
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
            'booleanFormat' => ['<span class="label label-danger"><i class="fa fa-times"></i></span>', '<span class="label label-success"><i class="fa fa-check"></i></span>']
        ],
        'i18n' => [
            'translations' => [
                'kvgrid' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@kvgrid/messages',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'database' => [
            'class' => 'backup\Module'
        ],
        'donation' => 'modules\donation\Module'
    ],
    'aliases' => [
        '@mdm/admin' => '@backend/modules/mdmsoft/yii2-admin',
        '@backup' => '@backend/modules/backup'
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/logout',
        ],
    ],
    'params' => $params,
];
