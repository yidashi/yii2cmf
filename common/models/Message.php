<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['to_uid', 'content'], 'required'],
            [['from_uid', 'to_uid'], 'integer'],
            [['from_uid'], 'default', 'value' => 0], // 0是系统信息
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_uid']);
    }

    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_uid']);
    }
}
