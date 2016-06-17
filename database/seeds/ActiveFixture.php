<?php

namespace database\seeds;

/**
 * User fixture.
 */
class ActiveFixture extends \yii\test\ActiveFixture
{
    public function init()
    {
        parent::init();
        if ($this->dataFile == null) {
            $class = new \ReflectionClass($this);
            $dataName = strtolower(substr($class->getShortName(), 0, strpos($class->getShortName(), 'Fixture')));
            $this->dataFile = \Yii::getAlias('@database/seeds/data/' . $dataName . '.php');
        }
    }
}
