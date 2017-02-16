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
            'identityClass' => 'common\modules\user\models\User',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/article',
                        'v1/nav'
                    ]
                ],
            ],
        ],
        'response' => [
            'format' => 'json',
            'on beforeSend' => function($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    if (!$response->isSuccessful) {
                        $result = $response->data;
                        $response->data = [
                            'errcode' => isset($result['status']) ? $result['status'] : $result['code'],
                            'errmsg' => $result['message'],
                            'data' => (object) []
                        ];
                        $response->statusCode = 200;
                    } else {
                        $result = $response->data;
                        $response->data = array_merge($result, [
                            'errcode' => 0,
                            'errmsg' => 'ok',
                        ]);
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
