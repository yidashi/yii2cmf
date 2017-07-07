<?php

namespace common\models;
use backend\behaviors\DynamicFormBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article_exhibition}}".
 *
 * @property integer $id
 * @property integer $start_at
 * @property integer $end_at
 * @property string $city
 * @property string $address
 */
class ArticleExhibition extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_exhibition}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_at', 'end_at', 'city', 'address'], 'required'],
            [['id'], 'integer'],
            [['start_at', 'end_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['city'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['id'], 'unique', 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_at' => '开始日期',
            'end_at' => '结束日期',
            'city' => '城市',
            'address' => '地址',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'start_at' => 'datetime',
                    'end_at' => 'datetime',
                    'city' => 'text',
                    'address' => 'text'
                ]
            ]
        ];
    }
}
