<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property string $content
 * @property integer $created_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'content', 'created_at'], 'required'],
            [['from_uid', 'to_uid', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }
}
