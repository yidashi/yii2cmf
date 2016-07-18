<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/18
 * Time: 下午1:55
 */

namespace common\models;

interface ArticleModuleInterface
{
    public function attributeTypes();

    public function getAttributeType($attribute);
}