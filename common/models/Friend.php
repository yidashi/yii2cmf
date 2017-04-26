<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['owner_id', 'friend_id'], 'integer'],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getFansNumber($id = null)
    {
        $id = $id ? : Yii::$app->user->id;
        return self::find()->where(['friend_id' => $id])->count();
    }

    public static function getFollowNumber($id = null)
    {
        $id = $id ? : Yii::$app->user->id;
        return self::find()->where(['owner_id' => $id])->count();
    }

    /**
     * 是否关注某人
     * @param $id
     * @return bool
     */
    public function isFollow($id) {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        $model = self::find()->where(['owner_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
        return $model !=null ;
    }
    public function follow($id)
    {
        if (Yii::$app->user->id == $id) {
            $this->addError('friend_id', '不能关注自己');
            return false;
        }
        $model = new self();
        $model->owner_id = Yii::$app->user->id;
        $model->friend_id = $id;
        return $model->insert();
    }

    public function cancelFollow($id)
    {
        $model = self::find()->where(['owner_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
        if ($model != null) {
            return $model->delete();
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->notify->category('follow')->from($this->owner_id)->to($this->friend_id)->send();
    }
}
