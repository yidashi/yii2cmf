<?php

namespace gii;

use Yii;

class Module extends \yii\gii\Module
{
    public $allowedIPs = ['*'];
    public $controllerNamespace = 'gii\controllers';

    public function init()
    {
        parent::init();
        $class = new \ReflectionClass($this);
        if (Yii::$app->id == 'frontend') {
            $this->controllerNamespace = $class->getNamespaceName() . '\\frontend\\controllers';
            $this->viewPath = $this->basePath . '/frontend/views';
        } elseif (Yii::$app->id == 'backend') {
            $this->controllerNamespace = $class->getNamespaceName() . '\\backend\\controllers';
            $this->viewPath = $this->basePath . '/backend/views';
        }
    }

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
