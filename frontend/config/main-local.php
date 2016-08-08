<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'urlManager' => [
            'enablePrettyUrl' => env('FRONTEND_PRETTY_URL', 'false'),
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => '<id:\d+>',
                    'route' => 'article/view',
                    'suffix' => '.html'
                ],
                '/' => 'site/index',
                '<controller:\w+>' => '<controller>/index',
                'tag/search' => '/tag/search',
                'tag/<name:\S+>' => '/article/tag'
            ],
        ]
    ],
];
return $config;
