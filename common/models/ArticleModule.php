<?php

namespace common\models;

/**
 * This is the model class for table "{{%article_module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 */
class ArticleModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
        ];
    }

    public static function getTypeEnum()
    {
        return self::find()->select('title')->indexBy('name')->column();
    }
}
