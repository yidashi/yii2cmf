<?php
namespace frontend\components;

use yii\base\BootstrapInterface;

class AccessLog implements BootstrapInterface
{
    public function bootstrap($app)
    {
        \Yii::error('hehe');
    }
}