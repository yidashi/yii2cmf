<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pop_meta".
 *
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $type
 * @property integer $type_id
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'integer'],
            [['title', 'keywords', 'description', 'type'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'type' => 'Type',
            'type_id' => 'Type ID',
        ];
    }
}
