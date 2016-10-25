<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\common\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
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
            'basePath' => '@api/modules/v1',
            'class' => api\modules\v1\Module::className()
        ],
        'v2' => [
            'basePath' => '@api/modules/v2',
        ],
    ],
    'params' => $params
];
