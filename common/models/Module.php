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

    const TYPE_CORE = 1;
    const TYPE_PLUGIN = 2;
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
            [['type'], 'in', 'range' => [1,2]],
            [['name'], 'string', 'max' => 50],
            [['class', 'bootstrap'], 'string', 'max' => 128],
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
            TimestampBehavior::className()
        ];
    }

    public static function findOpenModules($type = null)
    {
        $query = static::find();
        return $query->where([
            "status" => self::STATUS_OPEN
        ])->andFilterWhere(['type' => $type])
            ->all();
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
