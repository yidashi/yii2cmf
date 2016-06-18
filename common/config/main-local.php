<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN', 'mysql:host=127.0.0.1;dbname=yii'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'charset' => 'utf8',
            'tablePrefix' => env('DB_TABLE_PREFIX', 'pop_'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_HOST'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'port' => env('MAIL_PORT'),
                'encryption' => env('MAIL_ENCRYPTION')
            ],
        ],
    ],
];
