<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/18
 * Time: 下午1:55
 */

namespace common\models;

use yii\db\ActiveRecord;

abstract class ArticleModuleContract extends ActiveRecord
{
    abstract public function attributeTypes();

    public function getAttributeType($attribute)
    {
        $types = $this->attributeTypes();
        return isset($types[$attribute]) ? $types[$attribute] : 'text';
    }

    public function formAttributes()
    {
        $attributes = $this->attributes();
        unset($attributes[array_search($this->primaryKey()[0], $attributes)]);
        return $attributes;
    }
}