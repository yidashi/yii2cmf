<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%plugin}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property string $author
 * @property string $description
 * @property string $config
 * @property integer $created_at
 * @property integer $updated_at
 */
class Plugin extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plugin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['config', 'description'], 'string'],
            ['status', 'default', 'value' => 1],
            [['id'], 'unique'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'status' => '是否启用',
            'config' => '配置',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => CacheInvalidateBehavior::className(),
                'keys' => [
                    'plugins',
                ]
            ]
        ];
    }

    public static function findOpenPlugins()
    {
        $plugins = Yii::$app->cache->get('plugins');
        if ($plugins === false) {
            $query = static::find();
            $plugins = $query->where(['status' => self::STATUS_OPEN])->all();
            Yii::$app->cache->set('plugins', $plugins, 0);
        }
        return $plugins;
    }


    public function getInstall()
    {
        return $this->isNewRecord ? false : true;
    }
    public function getOpen()
    {
        return $this->status == self::STATUS_OPEN;
    }
}
