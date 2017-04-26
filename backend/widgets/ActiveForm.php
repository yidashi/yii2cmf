<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/15
 * Time: 下午11:00
 */

namespace backend\widgets;

use yii\helpers\ArrayHelper;
use yii\base\Model;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'backend\widgets\ActiveField';
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
     * Generates a form field.
     * A form field is associated with a model and an attribute. It contains a label, an input and an error message
     * and use them to interact with end users to collect their inputs for the attribute.
     * @param Model $model the data model.
     * @param string $attribute the attribute name or expression. See [[Html::getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the additional configurations for the field object. These are properties of [[ActiveField]]
     * or a subclass, depending on the value of [[fieldClass]].
     * @return ActiveField the created ActiveField object.
     * @see fieldConfig
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}