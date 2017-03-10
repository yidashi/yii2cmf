<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
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
            'class' => 'backend\components\Formatter',
            'booleanFormat' => ['<i class="fa fa-times text-danger"></i>', '<i class="fa fa-check text-success"></i>']
        ],
        'themeManager' => [
            'class' => 'common\components\ThemeManager',
        ],
    ],
    'modules' => [
        'rbac' => [
            'class' => 'rbac\Module',
        ],
        'backup' => [
            'class' => 'backup\Module',
        ],
        'gii' => [
            'class' => 'gii\Module',
            'generators' => [
                'crud' => [
                    'class' => 'yii\gii\generators\crud\Generator',
                    'templates' => [
                        'default' => '@gii/generators/crud/default'
                    ]
                ],
                'model' => [
                    'class' => 'gii\\generators\model\\Generator',
                    'useTablePrefix' => true,
                    'ns' => 'common\\models'
                ]
            ]
        ],
        'migration' => [
            'class' => 'migration\Module',
        ],
    ],
    'aliases' => [
        '@rbac' => '@backend/modules/rbac',
        '@backup' => '@backend/modules/backup',
        '@gii' => '@backend/modules/gii',
        '@migration' => '@backend/modules/migration',
    ],
    'as access' => [
        'class' => 'rbac\components\AccessControl',
        'allowActions' => [
            'user/admin/logout'
        ],
    ],
    'as adminLog' => 'backend\\behaviors\\AdminLogBehavior',
    'params' => $params,
];
