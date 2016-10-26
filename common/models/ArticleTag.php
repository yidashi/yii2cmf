<?php

namespace common\models;

/**
 * This is the model class for table "pop_article_tag".
 *
 * @property integer $article_id
 * @property integer $tag_id
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => '文章',
            'tag_id' => '标签',
        ];
    }
}
