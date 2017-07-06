<?php

namespace common\models;

use common\modules\user\behaviors\UserBehavior;
use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "{{%sign}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sign_at
 * @property SignInfo $info
 */
class Sign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sign_at'], 'required'],
            [['user_id', 'sign_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sign_at' => 'Sign At',
        ];
    }

    public function behaviors()
    {
        return [
            UserBehavior::className(),
        ];
    }

    /**
     * @return Query
     */
    public static function findToday()
    {
        return static::find()->where(new Expression('FROM_UNIXTIME(sign_at, "%Y%m%d") ="' . date('Ymd') . '"'));
    }

    public function getInfo()
    {
        return $this->hasOne(SignInfo::className(), ['user_id' => 'user_id']);
    }

    public static function isSign()
    {
        return static::findToday()->andWhere(['user_id' => Yii::$app->user->id])->exists();
    }
}
