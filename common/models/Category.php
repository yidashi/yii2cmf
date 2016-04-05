<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'name'], 'required'],
            [['pid', 'is_nav'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '分类名',
            'name' => '标识',
            'pid' => '上级分类',
            'ptitle' => '上级分类', // 非表字段,方便后台显示
            'description' => '分类介绍',
            'article' => '文章数', //冗余字段,方便查询
            'is_nav' => '是否显示在导航栏',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * 获取分类名
     */
    public function getPtitle()
    {
        return static::find()->select('title')->where(['id' => $this->pid])->scalar();
    }
    public static function lists()
    {
        $list = Yii::$app->cache->get('categoryList');
        if ($list === false) {
            $list = static::find()->select('id,title')->asArray()->all();
            $list = ArrayHelper::map($list, 'id', 'title');
            Yii::$app->cache->set('categoryList', $list);
        }

        return $list;
    }

    /**
     * 分类名下拉列表
     */
    public static function getDropDownlist()
    {
        return array_merge(['无'], self::lists());
    }

    public function getCategoryNameById($id)
    {
        $list = $this->lists();

        return isset($list[$id]) ? $list[$id] : null;
    }

    public function getCategoryIdByName($name)
    {
        $list = $this->lists();

        return array_search($name, $list);
    }
}
