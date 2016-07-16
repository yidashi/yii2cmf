<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/3
 * Time: 下午11:55
 */

namespace frontend\models;


class Tag extends \common\models\Tag
{
    public static function hot()
    {
        return self::find()->orderBy('article desc')->limit(20)->all();
    }
}