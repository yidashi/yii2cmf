<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%album}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $owner_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'owner_id'], 'required'],
            [['owner_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ]
        ];
    }

    public function getAttachmentUrls()
    {
        return array_map(function($value){
            return $value->url;
        }, $this->attachments);
    }
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['id' => 'attachment_id'])
            ->viaTable('{{%album_attachment}}', ['album_id' => 'id']);
    }
}
