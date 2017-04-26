<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

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

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    public function afterFind()
    {
        $this->value = $this->getValue();
    }

    public function canGetProperty($name, $checkVars = true)
    {
        return parent::canGetProperty($name, $checkVars) || $this->attribute == $name;
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return parent::canSetProperty($name, $checkVars) || $this->attribute == $name;
    }

    // 根据特性返回这个值
    public function __get($name)
    {
        if ($name == $this->attribute) {
            return $this->value;
        }
        return parent::__get($name);

    }

    public function __set($name, $value)
    {
        if ($name == $this->attribute) {
            $this->setValue($value);
            return;
        }
        parent::__set($name, $value);
    }

    protected function getValue()
    {

    }

    protected function setValue($value)
    {

    }

}