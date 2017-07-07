<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $deep
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort', 'deep'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '地区名',
            'parent_id' => '父ID',
            'sort' => '排序',
            'deep' => '地区深度',
        ];
    }

    /**
     * 解析全地址( 北京 北京市 东城区)成省ID 市ID 区ID
     * @param string|array $fullArea
     * @return array
     */
    public static function parseFullArea($fullArea)
    {
        if (is_string($fullArea)) {
            $fullArea = explode(' ', $fullArea);
        }
        list($province, $city, $area) = $fullArea;
        return [
            self::getId($province),
            self::getId($city),
            self::getId($area)
        ];

    }

    /**
     * 把省市区ID生成全地址 北京 北京市 东城区
     * @param $province
     * @param $city
     * @param $area
     * @return string
     */
    public static function createFullArea($province, $city, $area)
    {
        return join(' ', [
            self::getName($province),
            self::getName($city),
            self::getName($area)
        ]);
    }
    public static function getId($name)
    {
        return self::find()->where(['name' => $name])->select('id')->scalar();
    }
    public static function getName($id)
    {
        return self::find()->where(['id' => $id])->select('name')->scalar();
    }
    public static function getChildren($id = null)
    {
        if (is_null($id)) {
            return [];
        }
        $area = Yii::$app->cache->get(['area', $id]);
        if ($area === false) {
            $area = self::find()->where(['parent_id' => $id])->select('name')->indexBy('id')->column();
            Yii::$app->cache->set(['area', $id], $area);
        }
        return $area;
    }
}
