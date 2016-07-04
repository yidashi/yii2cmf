<?php

namespace plugins\donation\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%donation}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $money
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 */
class Donation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%donation}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'money'], 'required'],
            [['money'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['remark', 'source'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'money' => '金额（元）',
            'remark' => '留言',
            'source' => '来源',
            'created_at' => '时间',
            'updated_at' => '更新时间',
        ];
    }
}
