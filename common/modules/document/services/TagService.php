<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/3
 * Time: 下午11:55
 */

namespace common\modules\document\services;

use common\modules\document\models\Tag;

class TagService
{
    public static function hot($num = 20)
    {
        return Tag::find()->orderBy('document desc')->limit($num)->all();
    }
}