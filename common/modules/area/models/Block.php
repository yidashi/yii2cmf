<?php
namespace common\modules\area\models;

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
            [['title', 'config', 'slug',"type","widget"], 'string'],
            ['template', 'safe']
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
            $this->template = serialize($this->template);
            if ($insert == true) {
                $this->used = BooleanEnum::FLASE;
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->template = unserialize($this->template);
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
            "type" => '类型',
            'used' => Yii::t('backend', 'used'),
            'widget' => Yii::t('backend', 'Widget'),
        ];
    }

    public function getWidget()
    {
        $namespace = 'common\modules\area\widgets\\';
        $widget = $namespace . ucfirst($this->type) . 'Widget';
        return $widget;
    }

    public static function widgetTypeEnum()
    {
        return [
            'text' => '文本块',
            'article' => '文章块'
        ];
    }
}
