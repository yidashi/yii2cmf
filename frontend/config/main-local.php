<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'urlManager' => [
            'class' => 'frontend\\components\\UrlManager',
            'enablePrettyUrl' => env('FRONTEND_PRETTY_URL', 'false'),
            'showScriptName' => false,
            'rules' => [
                ['class' => 'common\\modules\\urlrule\\components\\UrlRule'],
                [
                    'pattern' => '<id:\d+>',
                    'route' => 'article/view',
                    'suffix' => '.html'
                ],
                'tag/search' => '/tag/search',
                'tag/<name:\S+>' => '/article/tag',
                '/' => 'site/index',
                '<controller:\w+>' => '<controller>/index',
            ],
            'on ' . \frontend\components\UrlManager::EVENT_INIT_RULECACHE => function ($event) {
                if(checkInstalled() == false) {
                    return;
                }

                $dbrule = null;
                foreach ($event->urlManager->rules as $rule) {
                    if ($rule instanceof \common\modules\urlrule\components\UrlRule) {
                        $dbrule = $rule;
                    }
                }
                $ruleCache = [];
                if ($dbrule) {
                    $models = \common\modules\urlrule\models\UrlRule::find()->all();
                    foreach ($models as $model) {
                        $params = [];
                        parse_str($model->defaults, $params);
                        $cacheKey = $model->route . '?' . implode('&', array_keys($params));
                        $ruleCache[$cacheKey][] = $dbrule;
                    }
                }
                $event->ruleCache = array_merge($ruleCache, (array) $event->ruleCache);
            }
        ]
    ],
];
return $config;
