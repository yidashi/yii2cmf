<?php

namespace common\models;
use common\models\behaviors\ArticleDataBehavior;
use yii\helpers\Markdown;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%article_data}}".
 *
 * @property int $id
 * @property string $content
 */
class ArticleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
        ];
    }

    public function behaviors()
    {
        return [
            ArticleDataBehavior::className()
        ];
    }
}
