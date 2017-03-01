<?php

namespace common\modules\attachment\models;

use Yii;

/**
* This is the model class for table "{{%attachment_index}}".
*
* @property integer $attachment_id
* @property integer $entity_id
* @property string $entity
* @property string $attribute
*
* @property Attachment $attachment
 */
class AttachmentIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment_index}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_id', 'entity_id'], 'integer'],
            [['entity', 'attribute'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'attachment_id',
            'entity_id' => 'Item ID',
            'entity' => 'Model',
            'attribute' => 'Attribute',
        ];
    }

}
