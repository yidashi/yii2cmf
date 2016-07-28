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
    ],
    'controllerMap'=>[
        'file-manager-elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storagePath',
                    'path'   => '/',
                ]
            ]
        ],
        'upload' => \common\actions\UploadController::className()
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'loginUrl' => ['/user/security/login'],
            'enableAutoLogin' => true,
            'idParam' => '__idBackend',
            'identityCookie' => ['name' => '_identityBackend', 'httpOnly' => true]
        ],
        'request' => [
            'csrfParam' => '_csrfBackend'
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
            'class' => 'rbac\components\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'booleanFormat' => ['<i class="fa fa-times"></i>', '<i class="fa fa-check"></i>']
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap' => ['app' => 'backend.php'],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
                'yii2tech-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2tech/admin/messages',
                ]
            ],
        ],
        'themeManager' => [
            'class' => 'common\components\ThemeManager',
        ],
        'pluginManager' => [
            'class' => 'common\components\PluginManager',
        ],
    ],
    'modules' => [
        'rbac' => [
            'class' => 'rbac\Module',
        ],
        'backup' => [
            'class' => 'backup\Module',
        ],
        'i18n' => [
            'class' => 'backend\modules\i18n\Module',
            'defaultRoute'=>'i18n-message/index'
        ],
        'user' => [
            'defaultRoute' => 'admin',
            'controllerMap' => [
                'security' => [
                    'class' => 'common\modules\user\controllers\SecurityController',
                    'layout' => '@backend/views/layouts/main-login',
                    'viewPath' => '@backend/views/site'
                ]
            ],
            'as backend' => 'common\modules\user\filters\BackendFilter',
            'admins' => ['superAdmin', 'demo']
        ]
    ],
    'aliases' => [
        '@rbac' => '@backend/modules/rbac',
        '@backup' => '@backend/modules/backup',
    ],
    'as access' => [
        'class' => 'rbac\components\AccessControl',
        'allowActions' => [
            'user/security/logout'
        ],
    ],
    'as adminLog' => 'backend\\behaviors\\AdminLogBehavior',
    'params' => $params,
];
