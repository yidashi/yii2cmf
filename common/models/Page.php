<?php

namespace common\models;
use common\behaviors\MetaBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

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
            [['content', 'title', 'slug'], 'required'],
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
            'slug' => '标识'
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => '（影响url）'
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => MetaBehavior::className(),
                'type' => 'page'
            ],
        ];
    }

    public function getMetaData()
    {
        $model = $this->getMetaModel();

        $title = $model->title ?  : $this->title;

        $description = $model->description ?  : StringHelper::truncate(strip_tags($this->content), 150);

        return [$title, $description, $model->keywords];
    }
}
