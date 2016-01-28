<?php

namespace common\models;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property int $use_layout
 * @property string $content
 * @property string $title
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'title'], 'required'],
            [['content'], 'string'],
            [['use_layout'], 'in', 'range' => [0, 1]],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'use_layout' => '是否使用布局',
            'content' => '内容',
            'title' => '标题',
        ];
    }
}
