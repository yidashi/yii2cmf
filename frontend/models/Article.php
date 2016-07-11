<?php

namespace frontend\models;

use common\models\Category;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $cover
 */
class Article extends \common\models\Article
{
    public static function hots($categoryId, $size = 10)
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->normal()
            ->limit($size)
            ->orderBy('view desc')
            ->all();
    }
}
