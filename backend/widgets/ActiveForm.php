<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/15
 * Time: 下午11:00
 */

namespace backend\widgets;

use yii\helpers\ArrayHelper;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $boxFieldClass = '\backend\widgets\BoxField';

    public function boxField($model, $attribute, $options = [])
    {
        $config = $this->fieldConfig;
        if ($config instanceof \Closure) {
            $config = call_user_func($config, $model, $attribute);
        }
        if (!isset($config['class'])) {
            $config['class'] = $this->boxFieldClass;
        }
        return \Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }
}