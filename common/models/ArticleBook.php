<?php

namespace common\models;

use backend\behaviors\DynamicFormBehavior;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article_book}}".
 *
 * @property integer $pid
 * @property integer $type
 */
class ArticleBook extends \yii\db\ActiveRecord
{
    const MODULE_NAME = 'book';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => '父id',
            'type' => '类型',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DynamicFormBehavior::className(),
                'formAttributes' => [
                    'type' => [
                        'type' => 'select',
                        'items' => ['目录', '主题', '段落'],
                    ],
                    'pid' => [
                        'type' => 'select',
                        'items' => Article::find()->where(['module' => self::MODULE_NAME])->select('title')->indexBy('id')->column(),
                        'options' => ['prompt' => '请选择']
                    ]
                ]
            ]
        ];
    }

    public function getRoot()
    {
        if ($this['pid'] == 0) {
            return $this;
        }
        $parent = self::find()->where(['id' => $this->pid])->one();
        if ($parent->pid != 0) {
            return $parent->getRoot();
        } else {
            return $parent;
        }
    }

    public function getItems()
    {
        if (!empty($this->_items)) {
            return $this->_items;
        }
        $sons = self::findAll(['pid' => $this->id]);
        if (empty($sons)) {
            return [];
        }
        foreach ($sons as $son) {
            $items = $son->getItems();
            if (!empty($items)) {
                $son->items = $items;
            }
        }
        return $sons;
    }
    private $_items = [];

    public function setItems($items)
    {
        $this->_items = $items;
    }

    public function getMenuItems()
    {
        $menuItems = [];
        foreach ($this->getItems() as $k => $item) {
            $menuItem = [];
            $menuItem['label'] = $item->article->title;
            $menuItem['url'] = ['/article/view', 'id' => $item->id];
            $menuItem['active'] = Yii::$app->request->get('id') == $item->id;
            if (isset($item->items) && !empty($item->items)) {
                $menuItem['items'] = $item->getMenuItems();
            }
            $menuItems[$k] = $menuItem;
        }
        return $menuItems;
    }
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'id']);
    }
}
