<?php

namespace common\modules\document\models;

/**
 * This is the model class for table "{{%document_tag}}".
 *
 * @property integer $document_id
 * @property integer $tag_id
 */
class DocumentTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => '内容',
            'tag_id' => '标签',
        ];
    }
}
