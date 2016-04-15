<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property integer $id
 * @property integer $money
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $signature
 * @property string $avatar
 * @property integer $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money', 'created_at', 'updated_at'], 'required'],
            [['money', 'created_at', 'updated_at', 'gender'], 'integer'],
            [['signature'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'money' => '余额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'signature' => '个性签名',
            'avatar' => '头像',
            'gender' => '性别',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getGenderList()
    {
        return ['男', '女'];
    }
}
