<?php

namespace common\modules\document\models;

use common\behaviors\CacheInvalidateBehavior;
use common\behaviors\MetaBehavior;
use common\behaviors\PositionBehavior;
use common\modules\document\behaviors\CategoryBehavior;
use Overtrue\Pinyin\Pinyin;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property string $module
 * @property string $list_template
 * @property string $content_template
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
            [['title', 'module'], 'required'],
            //中文没法自动生成slug，又没必要必填
            ['slug', 'default', 'value' => function ($model) {
                return $model->title;
            }],
            [['module', 'list_template', 'content_template'], 'string'],
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
            'document' => '内容数', //冗余字段,方便查询
            'sort' => '排序',
            'module' => '绑定的内容模型',
            'list_template' => '列表模板',
            'content_template' => '内容模板',
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
                $query->where(['module' => $module]);
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

    public function __toString()
    {
        return $this->title;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->slug)) {
                $pinyin = new Pinyin();
                $this->slug = $pinyin->permalink($this->title);
            }
            return true;
        }
        return false;
    }
}
