<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property string $author
 * @property string $desc
 * @property integer $created_at
 * @property integer $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;
    const STATUS_UNINSTALL = -1;
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
            [['status'], 'integer'],
            [['name', 'app'], 'string', 'max' => 50],
            [['config'], 'string'],
            ['status', 'default', 'value' => 1],
            [['name'], 'unique'],
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
            'app' => 'appID',
            'status' => '是否启用',
            'config' => '配置',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function findOpenModules()
    {
        $query = static::find();
        return $query->where([
            "status" => self::STATUS_OPEN
        ])->all();
    }

    public function loadDefaultValues($skipIfSet = true)
    {
        $this->status = self::STATUS_UNINSTALL;
        return $this;
    }
    public function getInstall()
    {
        return $this->status != self::STATUS_UNINSTALL;
    }
    public function getOpen()
    {
        return $this->status == self::STATUS_OPEN;
    }
}
