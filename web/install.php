<?php
require __DIR__.'/../vendor/autoload.php';

require __DIR__.'/../Yii.php';

require __DIR__.'/../common/config/bootstrap.php';
Yii::setAlias('@install', dirname(__DIR__) . '/install');
Yii::setAlias('@rbac', '@backend/modules/rbac');

$config = [
    'id' => 'app-install',
    'basePath' => '@install',
    'controllerNamespace' => 'install\controllers',
    'vendorPath' => dirname(__DIR__).'/vendor',
    'runtimePath' => '@install/runtime',
    'timezone' => 'PRC',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@root/cache',
            'dirMode' => 0777 // 防止console生成的目录导致web账户没写权限
        ],
        'request' => [
            'enableCookieValidation' => false
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],
    ]
];
(new install\Application($config))->run();
