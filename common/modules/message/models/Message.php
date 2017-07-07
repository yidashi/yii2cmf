<?php

namespace common\modules\message\models;

use common\modules\user\behaviors\UserBehavior;
use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property integer $message_id
 * @property integer $read
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
            [['from_uid', 'to_uid', 'message_id'], 'required'],
            [['from_uid', 'to_uid', 'message_id', 'read'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_uid' => Yii::t('app', 'From Uid'),
            'to_uid' => Yii::t('app', 'To Uid'),
            'message_id' => Yii::t('app', 'Message ID'),
            'read' => Yii::t('app', 'Read'),
        ];
    }

    public function behaviors()
    {
        return [
            UserBehavior::className()
        ];
    }

    public function getData()
    {
        return $this->hasOne(MessageData::className(), ['id' => 'message_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            Yii::$app->notify->category('message')
                ->from($this->from_uid)
                ->to($this->to_uid)
                ->extra(['message' => $this->data->content])
                ->link(['/message/default/index'])
                ->send();
        }
    }
}
