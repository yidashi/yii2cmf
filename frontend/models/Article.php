<?php

namespace frontend\models;

use common\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $cover
 */
class Article extends \common\models\Article
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'author'], 'required'],
            [['content'], 'string'],
            [['status', 'category_id'], 'integer'],
            [['title', 'category'], 'string', 'max' => 50],
//            ['category', 'default', Category::find()->where(['id'=>$this->category_id])->select('title')->scalar()],
            // 若 "from" 和 "to" 为空，则分别给他们分配自今天起，3 天后和 6 天后的日期。
            [['category'], 'default', 'value' => function ($model, $attribute) {
                return Category::find()->where(['id'=>$model->category_id])->select('title')->scalar();
            }],
            [['author', 'cover'], 'string', 'max' => 255]
        ];
    }
}
