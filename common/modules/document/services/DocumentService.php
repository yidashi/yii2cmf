<?php

namespace common\modules\document\services;

use common\modules\document\models\Document;

class DocumentService
{

    public static function hots($categoryId = null, $size = 10)
    {
        return Document::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_hot desc, view desc')
            ->all();
    }

    public static function tops($categoryId = null, $size = 10)
    {
        return Document::find()
            ->andFilterWhere(['category_id' => $categoryId])
            ->published()
            ->limit($size)
            ->orderBy('is_top desc, view desc')
            ->all();
    }
}
