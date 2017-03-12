<?php

namespace frontend\models;

use common\models\ArticleExhibition;
use common\models\query\ArticleQuery;


class Article extends \common\models\Article
{

    public static function find()
    {
        return parent::find()->published();
    }

    public static function hots($categoryId = null, $size = 10)
    {
        return static::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_hot desc, view desc')
            ->all();
    }

    public static function tops($categoryId = null, $size = 10)
    {
        return static::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_top desc, view desc')
            ->all();
    }
}
