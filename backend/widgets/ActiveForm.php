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

    /**
     * 可折叠
     * @param $model
     * @param $attribute
     * @param array $options
     * @return object
     */
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

    /**
     * 有后缀的
     * @param $model
     * @param $attribute
     * @param string $suffix
     * @param string $suffixType
     * @param array $options
     * @return object
     */
    public function suffixField($model, $attribute, $suffix = '', $suffixType = 'addon', $options = [])
    {
        $config = $this->fieldConfig;
        if ($config instanceof \Closure) {
            $config = call_user_func($config, $model, $attribute);
        }
        if (!isset($config['class'])) {
            $config['class'] = $this->fieldClass;
        }
        $defaultOptions = ['template' => "{label}\n<div class=\"input-group\">{input}\n<div class=\"input-group-" . $suffixType . "\">" . $suffix . "</div></div>\n{hint}\n{error}"];
        $options = array_merge($defaultOptions, $options);
        return \Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }

    /**
     * 有前缀的
     * @param $model
     * @param $attribute
     * @param string $prefix
     * @param string $prefixType
     * @param array $options
     * @return object
     */
    public function prefixField($model, $attribute, $prefix = '', $prefixType = 'addon', $options = [])
    {
        $config = $this->fieldConfig;
        if ($config instanceof \Closure) {
            $config = call_user_func($config, $model, $attribute);
        }
        if (!isset($config['class'])) {
            $config['class'] = $this->fieldClass;
        }
        $defaultOptions = ['template' => "{label}\n<div class=\"input-group\"><div class=\"input-group-" . $prefixType . "\">" . $prefix . "</div>\n{input}</div>\n{hint}\n{error}"];
        $options = array_merge($defaultOptions, $options);
        return \Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }
}