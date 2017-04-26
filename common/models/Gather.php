<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%gather}}".
 *
 * @property integer $id
 * @property string $url_org
 * @property integer $created_at
 * @property integer $updated_at
 */
class Gather extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gather}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_org'], 'required'],
            [['url_org'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_org' => 'Url',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
