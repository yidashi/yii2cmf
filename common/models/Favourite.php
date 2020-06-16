<?php

namespace common\models;

use common\modules\document\models\Document;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pop_favourite".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $document_id
 * @property integer $created_at
 */
class Favourite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favourite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'document_id'], 'required'],
            [['user_id', 'document_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'document_id' => '文章',
            'created_at' => '收藏时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
        ];
    }

    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

}
