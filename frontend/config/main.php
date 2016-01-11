<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-frontend',
    'name' => '饮水思源',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n'=>[
            'translations' => [
                'app'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'forceTranslation' => true
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                '<id:\d+>' => 'article/view',
//                'v<version:\d+>/<controller:\S+>/<action:\S+>' => '<controller>/<action>'
            ]
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'yii\authclient\clients\QqOAuth',
                    'clientId' => '101277194',
                    'clientSecret' => '11ce53c8fb7daadcc246805727bb6fdb',
              ],
                // etc.
            ],
        ]
    ],
    'as ThemeBehavior' => \frontend\components\ThemeBehavior::className(),
    'on beforeRequest' => function($event) {
        $db = \Yii::$app->db;
        $list = $db->cache(function($db){
            return \common\models\Category::find()->select('id,name')->asArray()->all();
        }, 60*60*24);
        $rules = [];
        foreach($list as $item) {
            $cate[] = $item['name'];
        }
        $cate = join('|', $cate);
        $rules['<cate:(' . $cate . ')>'] = 'article/index';
        Yii::$app->UrlManager->addRules($rules);
    },
    'params' => $params
];
