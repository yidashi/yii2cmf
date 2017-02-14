<?php

namespace common\models\article;

use Yii;
use backend\behaviors\DynamicFormBehavior;
use common\models\Attachment;

/**
 * This is the model class for table "{{%article_download}}".
 *
 * @property integer $id
 * @property integer $attachment_id
 */
class Download extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_download}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attachment_id'], 'required'],
            [['id', 'attachment_id'], 'integer'],
            ['content', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attachment_id' => '文件',
            'content' => '内容',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'attachment_id' => 'file',
                    'content' => 'textarea'
                ]
            ]
        ];
    }

    public function getAttachment()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'attachment_id']);
    }
}
