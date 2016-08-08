<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/params.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'charset' => 'GBK',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@jamband/schemadump/template.php',
            'useTablePrefix' => true,
            'migrationPath' => '@database/migrations',
        ],
        'schemadump' => [
            'class' => 'jamband\schemadump\SchemaDumpController',
        ],
        'schedule' => [
            'class' => \omnilight\scheduling\ScheduleController::className(),
            'scheduleFile' => '@app/schedule.php'
        ],
        'seed' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@database/seeds/data',
            'templatePath' => '@database/seeds/templates',
            'namespace' => 'database\seeds',
        ],
        'serve' => [
            'class' => 'yii\console\controllers\ServeController',
            'docroot' => dirname(dirname(__DIR__)) . '/web'
        ]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ]
    ],
    'aliases' => [
    ],
    'params' => $params,
];
