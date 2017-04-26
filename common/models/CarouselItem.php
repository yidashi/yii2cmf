<?php

namespace common\models;

use common\behaviors\PositionBehavior;
use common\behaviors\CacheInvalidateBehavior;
use common\modules\attachment\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "carousel_item".
 *
 * @property integer $id
 * @property integer $carousel_id
 * @property string $image
 * @property string $imageUrl
 * @property string $url
 * @property string $caption
 * @property integer $status
 * @property integer $order
 *
 * @property Carousel $carousel
 */
class CarouselItem extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carousel_item}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $key = array_search('carousel_id', $scenarios[self::SCENARIO_DEFAULT], true);
        $scenarios[self::SCENARIO_DEFAULT][$key] = '!carousel_id';
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'order',
                'groupAttributes' => ['carousel_id']
            ],
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::className(),
                'keys' => [
                    function ($model) {
                        return [
                            Carousel::className(),
                            $model->carousel->key
                        ];
                    }
                ]
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'image',
                'multiple' => false,
                'entity' => __CLASS__
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_id'], 'required'],
            [['carousel_id', 'status', 'order'], 'integer'],
            [['url', 'caption'], 'string', 'max' => 1024],
            ['image', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'carousel_id' => Yii::t('common', 'Carousel ID'),
            'image' => Yii::t('common', 'Image'),
            'url' => Yii::t('common', 'Url'),
            'caption' => Yii::t('common', 'Caption'),
            'status' => Yii::t('common', 'Status'),
            'order' => Yii::t('common', 'Order')
        ];
    }

    public function attributeHints()
    {
        return [
            'url' => '格式: /site/index a=1&b=2'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarousel()
    {
        return $this->hasOne(Carousel::className(), ['id' => 'carousel_id']);
    }
}
