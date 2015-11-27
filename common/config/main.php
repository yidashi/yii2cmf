<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timezone'=>'PRC',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
