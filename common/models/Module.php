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
            [['name', 'title', 'status', 'name', 'title'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'title', 'author'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 255],
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
            'name' => '标识',
            'title' => '名称',
            'status' => '是否启用',
            'author' => '作者',
            'desc' => '描述',
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
}
