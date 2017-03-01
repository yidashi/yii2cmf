<?php

namespace common\behaviors;

use yii\base\Behavior;

class BaseAttachAttribute extends Behavior
{

    /**
     *
     * @var \yii\db\ActiveRecord
     */
    public $owner;


    /**
     * @var string
     */
    public $attribute;

    /**
     *
     * @var mixed
     */
    protected $value;


    public function canGetProperty($name, $checkVars = true)
    {
        return parent::canGetProperty($name, $checkVars) || $this->attribute == $name;
    }

    // 根据特性返回这个值
    public function __get($name)
    {
        if ($name != $this->attribute) {
            return parent::__get($name);
        }
        if ($this->value == null) {
            $this->value = $this->getValue();
        }
        return $this->value;
    }

    protected function getValue()
    {

    }

}