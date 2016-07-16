<?php

return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'crud' => [
                    'class' => 'yii\gii\generators\crud\Generator',
                    'enableI18N' => true,
                    'templates' => [
                        'default' => '@backend/components/gii/crud/default'
                    ]
                ],
                'adminMainFrame' => [
                    'class' => 'yii2tech\admin\gii\mainframe\Generator'
                ],
                'adminCrud' => [
                    'class' => 'yii2tech\admin\gii\crud\Generator'
                ]
            ]
        ],
    ],
];
