<?php

namespace common\modules\document\models\document;

use common\behaviors\DynamicFormBehavior;
use common\modules\attachment\behaviors\UploadBehavior;
use common\modules\attachment\models\Attachment;
use common\traits\EntityTrait;

/**
 * This is the model class for table "{{%document_photo}}".
 *
 * @property integer $id
 * @property Attachment[] $photos
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photos' => '图片',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'multiple' => true,
                'attribute' => 'photos',
            ],
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'photos' => [
                        'type' => 'images',
                        'options' => ['widgetOptions' => ['onlyUrl' => false]]
                    ],

                ]
            ]
        ];
    }
}
