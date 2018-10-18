<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'urlManager' => [
            'rules' => [
                '/' => 'site/index',
                '<controller:\w+>' => '<controller>/index',
            ]
        ]
    ],
];
/*$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    'allowedIPs' => ['39.155.165.2'],
];*/
return $config;
