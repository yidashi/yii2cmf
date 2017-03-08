<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\common\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'api\common\models\User',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/article',
                        'v1/nav',
                        'v1/user',
                    ]
                ],
            ],
        ],
        'request' => [
            'enableCookieValidation' => false
        ],
        'response' => [
            'format' => 'json',
            'on afterSend' => function ($event) {
            },
            'on beforeSend' => function($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    if (!$response->isSuccessful) {
                        $result = $response->data;
                        if ($response->statusCode == 422) {
                            $response->data = [
                                'errcode' => $response->statusCode,
                                'errmsg' => $result[0]['message'],
                            ];
                        } else {
                            $response->data = [
                                'errcode' => isset($result['status']) ? $result['status'] : $response->statusCode,
                                'errmsg' => $result['message'],
                            ];
                        }
                        $response->statusCode = 200;
                    } else {
                        $result = $response->data;
                        $response->data = array_merge([
                            'errcode' => 0,
                            'errmsg' => 'ok',
                        ], $result);

                    }
                }
            }
        ]
    ],
    'modules' => [
        'v1' => [
            'class' => '\api\modules\v1\Module'
        ],
        'v2' => [
            'class' => '\api\modules\v2\Module'
        ],
    ],
    'params' => $params
];
