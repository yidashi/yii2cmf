<?php

namespace common\models\article;

use common\modules\attachment\behaviors\UploadBehavior;
use common\modules\attachment\models\Attachment;
use Yii;
use common\behaviors\DynamicFormBehavior;

/**
 * This is the model class for table "{{%article_photo}}".
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
        return '{{%article_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'photos'], 'required'],
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
                'entity' => __CLASS__
            ],
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'photos' => 'images',
                ]
            ]
        ];
    }
}
