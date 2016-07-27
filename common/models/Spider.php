<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pop_spider".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $domain
 * @property string $page_dom
 * @property string $list_dom
 * @property string $time_dom
 * @property string $content_dom
 * @property string $title_dom
 * @property string $target_category
 * @property string $target_category_url
 */
class Spider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'domain', 'page_dom', 'list_dom', 'content_dom', 'title_dom', 'target_category', 'target_category_url'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['domain', 'page_dom', 'list_dom', 'time_dom', 'content_dom', 'title_dom', 'target_category', 'target_category_url'], 'string', 'max' => 255],
            [['name'], 'unique']
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
            'domain' => '域名',
            'page_dom' => 'page dom',
            'list_dom' => 'List Dom',
            'time_dom' => 'Time Dom',
            'content_dom' => 'Content Dom',
            'title_dom' => 'Title Dom',
            'target_category' => '目标分类',
            'target_category_url' => '目标分类地址',
        ];
    }
}
