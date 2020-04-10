<?php

namespace common\modules\schedule\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $cron
 * @property string $job
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cron', 'job', 'name'], 'required'],
            [['cron', 'job'], 'string', 'max' => 255],
            ['status', 'default', 'value' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '任务名称',
            'cron' => 'crontab表达式',
            'job' => '命令',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\modules\schedule\models\query\ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\schedule\models\query\ScheduleQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
