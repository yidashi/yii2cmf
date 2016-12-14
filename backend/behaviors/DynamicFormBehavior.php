<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/10/27 16:51
 * Description:
 */

namespace backend\behaviors;


use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class DynamicFormBehavior extends Behavior
{

    /**
     * ['attribute' => ['type' => 'text', 'items' => [], 'options' => []]
     * @var array
     */
    public $formAttributes = [];

    public function supportAttributeTypes()
    {
        return [
            'text',
            'array',
            'password',
            'textarea',
            'select',
            'checkbox',
            'radio',
            'image',
            'editor',
            'date',
            'datetime',
            'file',
            'city'
        ];
    }

    public function init()
    {
        parent::init();
        if (empty($this->formAttributes)) {
            $formAttributes = $this->owner->attributes();
            $formAttributes = array_combine($formAttributes, $formAttributes);
            ArrayHelper::remove($formAttributes, $this->owner->primaryKey()[0]);
            $this->formAttributes = $formAttributes;
        }
    }

    public function getAttributeType($attribute)
    {
        if(isset($this->formAttributes[$attribute])) {
            if(is_string($this->formAttributes[$attribute])) {
                return $this->formAttributes[$attribute];
            } else {
                return ArrayHelper::getValue($this->formAttributes[$attribute], 'type', 'text');
            }
        }
    }

    public function getAttributeItems($attribute)
    {
        if(isset($this->formAttributes[$attribute])) {
            return ArrayHelper::getValue($this->formAttributes[$attribute], 'items', []);
        }
    }

    public function getAttributeOptions($attribute)
    {
        if(isset($this->formAttributes[$attribute])) {
            return ArrayHelper::getValue($this->formAttributes[$attribute], 'options', []);
        }
    }

    public function formAttributes()
    {
        return array_filter(array_keys($this->formAttributes), function ($value) {
            if (!in_array($this->getAttributeType($value), $this->supportAttributeTypes())) {
                return false;
            }
            return true;
        });
    }

}