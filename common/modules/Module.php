<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/6
 * Time: 下午3:41
 */

namespace common\modules;


use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\User;

class Module extends \yii\base\Module
{
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
}