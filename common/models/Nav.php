<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pop_nav".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $url
 * @property string $data
 * @property string $type
 * @property integer $pid
 * @property integer $status
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pop_nav';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'status'], 'integer'],
            [['slug', 'title', 'url', 'data', 'type'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'url' => 'Url',
            'data' => 'Data',
            'type' => 'Type',
            'pid' => 'Pid',
            'status' => 'Status',
        ];
    }
}
