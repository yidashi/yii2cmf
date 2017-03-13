<?php

namespace common\models\article;

use common\modules\attachment\behaviors\UploadBehavior;
use Yii;
use common\behaviors\DynamicFormBehavior;

/**
 * This is the model class for table "{{%article_download}}".
 *
 * @property integer $id
 * @property \common\modules\attachment\models\Attachment $attachment
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
            [['id', 'attachment'], 'required'],
            [['id'], 'integer'],
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
            'attachment' => '文件',
            'content' => '内容',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachment'
            ],
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'attachment' => 'file',
                    'content' => 'textarea'
                ]
            ]
        ];
    }
}
