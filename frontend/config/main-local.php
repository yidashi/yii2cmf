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
                'tag/<name:\S+>' => '/article/tag',
                'user/<id:\d+>' => '/user',
                'user/<action:(login|logout)>' => 'user/security/<action>',
                'user/<action:(signup)>' => 'user/registration/<action>',
                'user/<action:(up|article-list|create-article|update-article|notice|favourite)>' => 'user/default/<action>'
            ],
        ]
    ],
];
return $config;
