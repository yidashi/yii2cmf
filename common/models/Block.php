<?php
namespace common\models;

use common\enums\BooleanEnum;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%area_block}}".
 *
 * @property integer $block_id
 * @property string $title
 * @property string $slug
 * @property integer $type
 * @property integer $widget
 * @property integer $config
 * @property integer $template
 * @property integer $cache
 * @property integer $used
 */
class Block extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area_block}}';
    }

    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
        $this->cache =  0;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['cache', 'used'], 'integer'],
            [['title', 'config', 'template', 'slug',"type","widget"], 'string'],
        ];
    }


    public function behaviors()
    {
        $behaviors = [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                "immutable"=>true,
                'ensureUnique' => true
            ]
        ];
        return $behaviors;
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert == true) {
                $this->used = BooleanEnum::FLASE;
                return true;
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_id' => 'ID',
            'title' => '区块名',
            'slug' => '标识',
            'config' => Yii::t('backend', 'Config'),
            'template' => Yii::t('backend', 'Template'),
            'cache' => '是否缓存',
            "type"=>Yii::t('backend', 'Type'),
            'used' => Yii::t('backend', 'used'),
            'widget' => Yii::t('backend', 'Widget'),
        ];
    }


}
