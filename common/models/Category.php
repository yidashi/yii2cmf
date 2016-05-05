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
            ['is_nav', 'default', 'value' => 0]
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

    public static function tree($list = [])
    {
        if (empty($list)) {
            $list = self::find()->asArray()->all();
        }
        $tree = self::list2tree($list);
        return $tree;
    }

    public static function treeList($tree = [], &$result = [], $deep = 0, $separator = '--')
    {
        if (empty($tree)) {
            $tree = self::tree();
        }
        $deep++;
        foreach($tree as $list) {
            $list['title'] = str_repeat($separator, $deep-1) . $list['title'];
            $result[] = $list;
            if (isset($list['_child'])) {
                self::treeList($list['_child'], $result, $deep, $separator);
            }
        }
        return $result;
    }
    /**
     * 分类名下拉列表
     */
    public static function getDropDownlist($tree = [], &$result = [], $deep = 0, $separator = '--')
    {
        if (empty($tree)) {
            $tree = self::tree();
        }
        $deep++;
        foreach($tree as $list) {
            $result[$list['id']] = str_repeat($separator, $deep-1) . $list['title'];
            if (isset($list['_child'])) {
                self::getDropDownlist($list['_child'], $result, $deep);
            }
        }
        return ['无'] + $result;
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

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     */
    public static function list2tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}
