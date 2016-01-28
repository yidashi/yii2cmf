<?php

namespace common\models;

/**
 * This is the model class for table "{{%nav}}".
 *
 * @property int $id
 * @property string $title
 * @property string $route
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'route'], 'required'],
            [['title', 'route'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'route' => '路由',
        ];
    }
}
