<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/29
 * Time: 上午11:16
 */

namespace frontend\components;


use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;

class Events extends \common\components\Events implements BootstrapInterface
{
    public function listeners()
    {
        return array_merge(parent::listeners(),[
            'frontend\modules\donation\NavListener' => 'yii\web\View.leftNav',
            'frontend\modules\code\NavListener' => 'yii\web\View.leftNav'
        ]);
    }
}