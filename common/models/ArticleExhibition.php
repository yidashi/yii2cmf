<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_exhibition}}".
 *
 * @property integer $id
 * @property integer $start_at
 * @property integer $end_at
 * @property string $city
 * @property string $address
 */
class ArticleExhibition extends \yii\db\ActiveRecord
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
            [['id', 'start_at', 'end_at'], 'integer'],
            [['city'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_at' => 'Start At',
            'end_at' => 'End At',
            'city' => 'City',
            'address' => 'Address',
        ];
    }
}
