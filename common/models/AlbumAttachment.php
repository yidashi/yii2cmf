<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%album_attachment}}".
 *
 * @property integer $album_id
 * @property integer $attachment_id
 */
class AlbumAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'attachment_id'], 'required'],
            [['album_id', 'attachment_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'album_id' => Yii::t('app', 'Album ID'),
            'attachment_id' => Yii::t('app', 'Attachment ID'),
        ];
    }
}
