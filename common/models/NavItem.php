<?php

namespace common\models;

use common\behaviors\PositionBehavior;
use Yii;

/**
 * This is the model class for table "{{%nav_item}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $status
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nav_id' => Yii::t('app', 'NAV ID'),
            'title' => '名称',
            'url' => '链接',
            'target' => '是否新窗口打开',
            'status' => '状态',
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
                    'nav_id'
                ],
            ],
        ];
    }

    public function getNav()
    {
        return $this->hasOne(Nav::className(), ['id' => 'nav_id']);
    }
}
