<?php

namespace common\models;

/**
 * This is the model class for table "pop_notify_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 */
class NotifyCategory extends \yii\db\ActiveRecord
{
    const REPLY = 1;
    const SUGGEST = 2;
    const COMMENT_ARTICLE = 3;
    const FAVOURITE = 4;
    const UP_ARTICLE = 5;
    const MESSAGE = 6;
    const REWARD = 7;
    const FOLLOW = 8;
    const UP_COMMENT = 9;
    const COMMENT_SUGGEST = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notify_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['text'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'text' => 'Text',
        ];
    }
}
