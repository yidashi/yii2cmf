<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/3
 * Time: 下午11:55
 */

namespace frontend\services;


class TagService
{
    public static function hot()
    {
        return \common\models\Tag::find()->orderBy('article desc')->limit(20)->all();
    }
}