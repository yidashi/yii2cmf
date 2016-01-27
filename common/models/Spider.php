<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%spider}}".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $domain
 * @property string $page_dom
 * @property string $list_dom
 * @property string $target_category
 * @property string $target_category_url
 */
class Spider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%spider}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title', 'domain', 'page_dom', 'list_dom', 'target_category', 'target_category_url'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50],
            [['domain', 'page_dom', 'list_dom', 'target_category', 'target_category_url'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'domain' => Yii::t('app', 'Domain'),
            'page_dom' => Yii::t('app', 'Page Dom'),
            'list_dom' => Yii::t('app', 'List Dom'),
            'target_category' => Yii::t('app', 'Target Category'),
            'target_category_url' => Yii::t('app', 'Target Category Url'),
        ];
    }
}
