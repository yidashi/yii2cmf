<?php

namespace frontend\services;

use common\models\ArticleExhibition;
use common\models\query\ArticleQuery;


class ArticleService
{

    public static function hots($categoryId = null, $size = 10)
    {
        return \common\models\Article::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_hot desc, view desc')
            ->all();
    }

    public static function tops($categoryId = null, $size = 10)
    {
        return \common\models\Article::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_top desc, view desc')
            ->all();
    }
}
