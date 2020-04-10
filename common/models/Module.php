<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property string $author
 * @property integer $type
 * @property string $desc
 * @property string $config
 * @property integer $created_at
 * @property integer $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['status', 'type'], 'integer'],
            [['type'], 'in', 'range' => [1, 2]],
            [['name'], 'string', 'max' => 50],
            [['bootstrap'], 'string', 'max' => 128],
            [['config'], 'string'],
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
            'bootstrap' => '初始化的应用',
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
                    'modules',
                    'openModules',
                ]
            ]
        ];
    }

    public static function findAllModules()
    {
        $cacheKey = 'modules';
        $modules = Yii::$app->cache->get($cacheKey);
        if ($modules === false) {
            $query = static::find();
            $modules = $query->indexBy('id')->all();
            Yii::$app->cache->set($cacheKey, $modules, 60 * 60 * 24);
        }
        return $modules;
    }

    public static function findOpenModules()
    {
        $cacheKey = 'openModules';
        $modules = Yii::$app->cache->get($cacheKey);
        if ($modules === false) {
            $query = static::find();
            $modules = $query->where(['status' => self::STATUS_OPEN])->indexBy('id')->all();
            Yii::$app->cache->set($cacheKey, $modules, 60 * 60 * 24);
        }
        return $modules;
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
