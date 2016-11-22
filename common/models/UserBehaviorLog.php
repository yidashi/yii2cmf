<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_behavior_log}}".
 *
 * @property integer $id
 * @property string $behavior_name
 * @property integer $user_id
 * @property string $content
 * @property integer $created_at
 */
class UserBehaviorLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_behavior_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['behavior_id', 'user_id'], 'integer'],
            ['content', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'behavior_id' => Yii::t('app', 'Behavior ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'content' => Yii::t('app', '日志内容'),
            'created_at' => Yii::t('app', 'Created At'),
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
}
