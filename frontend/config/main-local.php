<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'urlManager' => [
            'rules' => [
                [
                    'class' => 'frontend\components\DocumentUrlRule',
                ],
                [
                    'class' => 'frontend\components\PageRule',
                ],
                '/' => 'site/index',
                '<controller:\w+>' => '<controller>/index',
            ]
        ]
    ],
];
if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}
return $config;
