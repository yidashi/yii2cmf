<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%friend}}".
 *
 * @property integer $owner_id
 * @property integer $friend_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%friend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'friend_id'], 'required'],
            [['owner_id', 'friend_id', 'status'], 'integer'],
            [['owner_id', 'friend_id'], 'unique', 'targetAttribute' => ['owner_id', 'friend_id'], 'message' => 'The combination of Owner ID and Friend ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'owner_id' => Yii::t('app', 'Owner ID'),
            'friend_id' => Yii::t('app', 'Friend ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function getFansNumber($id = null)
    {
        $id = $id ? : Yii::$app->user->id;
        return self::find()->where(['friend_id' => $id])->andWhere(['status' => 1])->count();
    }

    public static function getFollowNumber($id = null)
    {
        $id = $id ? : Yii::$app->user->id;
        return self::find()->where(['owner_id' => $id])->andWhere(['status' => 1])->count();
    }
}
