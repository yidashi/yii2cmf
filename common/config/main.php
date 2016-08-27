<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)).'/vendor',
    'runtimePath' => '@root/runtime',
    'timezone' => 'PRC',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'timeFormat' => 'HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\YiiAsset' => [
                    'sourcePath' => '@common/static',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap'=>[
                        'common'=>'common.php',
                        'backend'=>'backend.php',
                        'frontend'=>'frontend.php',
                    ],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
                /*'*'=> [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%i18n_source_message}}',
                    'messageTable'=>'{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],*/
            ],
        ],
        'config' => [ //动态配置
            'class' => 'common\\components\\Config',
            'localConfigFile' => '@common/config/main-local.php'
        ],
        'storage' => [
            'class' => 'common\\components\\Storage',
            'basePath' => '@storagePath/upload',
            'baseUrl' => '@storageUrl/upload'
        ],
        'queue' => [//队列组件化,方便替换
            'class' => \common\components\Queue::className(),
        ],
        'log' => [
            'targets' => [
                'db'=>[
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['warning', 'error'],
                    'except'=>['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix'=>function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars'=>[],
                    'logTable'=>'{{%system_log}}'
                ],
            ]
        ],
        'notify' => 'common\components\notify\Handler',
        'moduleManager' => [
            'class' => 'common\\components\\ModuleManager'
        ]
    ],
    'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => true
    ]
];
