<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name'=>'博客后台',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=ejiajie2external.mysql.rds.aliyuncs.com;dbname=ameituan',
            'username' => 'sq_ejiajie',
            'password' => 'dudu1020',
            'charset' => 'utf8',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n'=>[
            'translations' => [
                'app'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'forceTranslation' => true
                ],
                'kvgrid'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@kvgrid/messages',
                    'forceTranslation' => true
                ]
            ]
        ]
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module'
        ],

        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kvgrid/messages',
                'forceTranslation' => true
            ]
        ],
    ],
    'aliases' => [
        '@mdm/admin' => '@backend/mdmsoft/yii2-admin',
        '@kvgrid' =>'@vendor/kartik-v/yii2-grid'
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
        ]
    ],
    'params' => $params,
];
