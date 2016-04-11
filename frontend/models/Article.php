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
 * @property string $author
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $cover
 */
class Article extends \common\models\Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'author'], 'required'],
            [['status', 'category_id', 'comment', 'user_id'], 'integer'],
            [['title', 'category'], 'string', 'max' => 50],
            [['category_id'], 'setCategory'],
            [['author', 'cover', 'desc'], 'string', 'max' => 255],
            ['tagNames', 'safe']
        ];
    }
    public function setCategory($attribute, $params)
    {
        $this->category = Category::find()->where(['id' => $this->category_id])->select('title')->scalar();
    }
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
                ],
            ]
        );
    }

    public static function hots($categoryId, $size = 10)
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->active()
            ->limit($size)
            ->orderBy('view desc')
            ->all();
    }
}
