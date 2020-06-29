<?php

namespace common\models;

use common\behaviors\PositionBehavior;
use Yii;

/**
 * This is the model class for table "{{%nav_item}}".
 *
 * @property integer $id
 * @property integer $nav_id
 * @property string $title
 * @property string $url
 * @property integer $status
 * @property integer $parent_id
 * @property Nav $nav
 * @property NavItem $parent
 */
class NavItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['status', 'nav_id', 'order', 'target'], 'integer'],
            [['title', 'url'], 'string', 'max' => 128],
            ['parent_id', 'default', 'value' => 0],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nav_id' => 'nav_id',
            'title' => '名称',
            'url' => '链接',
            'target' => '是否新窗口打开',
            'status' => '是否开启',
            'order' => '排序',
        ];
    }

    public function attributeHints()
    {
        return [
            'url' => '格式: /site/index a=1&b=2'
        ];
    }

    public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'order',
                'groupAttributes' => [
                    'nav_id',
                    'parent_id'
                ],
            ],
        ];
    }

    public function getNav()
    {
        return $this->hasOne(Nav::className(), ['id' => 'nav_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
}
