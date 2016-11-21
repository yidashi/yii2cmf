<?php

namespace common\models;

use common\helpers\Util;
use Yii;

/**
 * This is the model class for table "{{%nav}}".
 *
 * @property integer $id
 * @property string $key
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'title'], 'required'],
            [['key', 'title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'key' => Yii::t('common', 'Key'),
            'title' => Yii::t('common', 'Title'),
        ];
    }

    public function getActiveItem()
    {
        return $this->hasMany(NavItem::className(), ['nav_id' => 'id'])->where(['status' => 1]);
    }

    public static function getItems($key)
    {
        $nav = self::find()->where(['key' => $key])->one();
        if ($nav == null) {
            return [];
        }
        $items = NavItem::find()->select('title label, url, target')
            ->where(['nav_id' => $nav->id, 'status' => 1])
            ->orderBy(['order' => SORT_ASC])
            ->asArray()->all();
        return array_map(function($value){
            $value['url'] = Util::parseUrl($value['url']);
            if ($value['target'] == 1) {
                $value['linkOptions'] = ['target' => '_blank'];
            }
            return $value;
        }, $items);
    }

}
