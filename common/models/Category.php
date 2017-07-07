<?php

namespace common\models;

use common\behaviors\PositionBehavior;
use common\behaviors\CacheInvalidateBehavior;
use common\behaviors\MetaBehavior;
use common\helpers\Tree;
use common\models\behaviors\CategoryBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\Expression;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property string $module
 * @property string $cover
 * @property int $allow_publish
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
            [['title'], 'required'],
            //中文没法自动生成slug，又没必要必填
            ['slug', 'default', 'value' => function ($model) {
                return $model->title;
            }],
            ['module', 'safe'],
            [['pid', 'sort', 'allow_publish'], 'integer'],
            ['pid', 'default', 'value' => 0],
            [['sort'], 'default', 'value' => 0]
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
            'slug' => '标识',
            'pid' => '上级分类',
            'ptitle' => '上级分类', // 非表字段,方便后台显示
            'description' => '分类介绍',
            'article' => '文章数', //冗余字段,方便查询
            'sort' => '排序',
            'module' => '支持的文档类型',
            'allow_publish' => '是否允许发布内容',
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
            [
                'class' => MetaBehavior::className(),
            ],
            CategoryBehavior::className(),
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort',
                'groupAttributes' => [
                    'pid'
                ],
            ],
            [
                'class' => CacheInvalidateBehavior::className(),
                'tags' => [
                    'categoryList'
                ]

            ]
        ];
    }

    public function getMetaData()
    {
        $model =  $this->getMetaModel();

        $title = $model->title ? : $this->title;
        $keywords = $model->keywords;
        $description =$model->description ? : $this->description;

        return [$title, $keywords, $description];
    }
    /**
     * 获取分类名
     */
    public function getPtitle()
    {
        return static::find()->select('title')->where(['id' => $this->pid])->scalar();
    }

    public static function lists($module = null)
    {
        $list = Yii::$app->cache->get(['categoryList', $module]);
        if ($list === false) {
            $query = static::find();
            if ($module) {
                $query->where(new Expression("FIND_IN_SET('{$module}', module) "));
            }
            $list = $query->asArray()->all();
            Yii::$app->cache->set(['categoryList', $module], $list, 0, new TagDependency(['tags' => ['categoryList']]));
        }
        return $list;
    }

    public static function getDropDownList($tree = [], &$result = [], $deep = 0, $separator = '--')
    {
        $deep++;
        foreach($tree as $list) {
            $result[$list['id']] = str_repeat($separator, $deep-1) . $list['title'];
            if (isset($list['children'])) {
                self::getDropDownList($list['children'], $result, $deep);
            }
        }
        return $result;
    }

    public function getCategoryNameById($id)
    {
        $list = $this->lists();

        return isset($list[$id]) ? $list[$id] : null;
    }

    public static function getIdByName($name)
    {
        $list = self::lists();

        return array_search($name, $list);
    }

    public static function findByIdOrSlug($id)
    {
        if (intval($id) == 0) {
            $condition = ["slug" => $id];
        } else {
            $condition = [
                $id
            ];
        }

        return static::findOne($condition);
    }

    public static function getAllowPublishEnum()
    {
        return [
            '不允许',
            '只允许后台',
            '允许前后台'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->module = implode(',', $this->module);
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->module = explode(',', $this->module);
    }

    public function renderModule($separator = ',')
    {
        return join($separator, array_map(function ($val) {
            return array_get(ArticleModule::getTypeEnum(), $val);
        }, $this->module));
    }
}
