<?php

namespace common\modules\config\models;

use common\behaviors\CacheInvalidateBehavior;
use common\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $type
 * @property string $desc
 */
class Config extends \yii\db\ActiveRecord
{
    const TYPE_ARRAY = 'array';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type'], 'required'],
            [['name', 'group'], 'string', 'max' => 50],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            ['value', 'filter', 'filter' => function ($val) {
                if ($this->type == 'image') {
                    return $val['id'];
                }
                return $val;
            }, 'skipOnEmpty' => true],
            [['value', 'description', 'extra'], 'string'],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->type == 'image' && !empty($this->value)) {
            $this->value = Attachment::findOne($this->value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '配置名',
            'value' => '配置值',
            'description' => '配置描述',
            'type' => '配置类型',
            'extra' => '配置项',
            'group' => '分组',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => CacheInvalidateBehavior::className(),
                'tags' => [
                    \Yii::$app->config->cacheTag
                ]
            ]
        ];
    }

    public static function getTypeList()
    {
        return \Yii::$app->config->get('CONFIG_TYPE_LIST');
    }
}
