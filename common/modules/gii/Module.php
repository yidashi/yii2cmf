<?php

namespace gii;

class Module extends \yii\gii\Module
{
    public $allowedIPs = ['*'];
    public $controllerNamespace = 'gii\controllers';

    public $generators = [
        'crud' => [
            'class' => 'yii\gii\generators\crud\Generator',
            'templates' => [
                'default' => '@gii/generators/crud/default'
            ]
        ],
        'model' => [
            'class' => 'gii\\generators\model\\Generator',
            'useTablePrefix' => true,
            'ns' => 'common\\models'
        ]
    ];
}
