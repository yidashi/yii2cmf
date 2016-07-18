<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午9:29
 */

namespace backend\models;


use common\models\Article;
use common\models\ArticleData;
use common\models\ArticleModule;
use common\models\ArticleModuleInterface;
use common\models\ArticleTag;
use common\models\Tag;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Yii;
use common\models\Category;

class ArticleForm extends Model
{
    public $tagNames;
    public $title;
    public $content;
    public $cover;
    public $category_id;
    public $source;
    public $status = 1;
    public $published_at;
    public $desc;
    public $view;
    public $is_top;
    public $module;
    public $moduleClass;
    private $_extendAttributes = [];
    private $_isNewRecord = true;
    private $_id;
    public function __construct($moduleName = 'base', array $config = [])
    {
        $this->module = $moduleName;
        if ($moduleName != 'base') {
            $module = ArticleModule::find()->where(['name' => $this->module])->one();
            if (empty($module)) {
                throw new InvalidConfigException('文档类型不合法');
            }
            $moduleClass = new $module->model;
            if (!$moduleClass instanceof ArticleModuleInterface) {
                throw new InvalidConfigException('文档类型不合法');
            }
            $this->moduleClass = $moduleClass;
            $this->_extendAttributes = $moduleClass->attributes;
        }
        parent::__construct($config);
    }

    public function extendAttributes()
    {
        $extendAttributes = array_keys($this->_extendAttributes);
        unset($extendAttributes[array_search('id', $extendAttributes)]);
        return $extendAttributes;
    }

    public function __get($name)
    {
        if (isset($this->_extendAttributes[$name]) || array_key_exists($name, $this->_extendAttributes)) {
            return $this->_extendAttributes[$name];
        } elseif ($this->hasAttribute($name)) {
            return null;
        } else {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if ($this->hasAttribute($name)) {
            $this->_extendAttributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }
    public function hasAttribute($name)
    {
        return isset($this->_extendAttributes[$name]) || array_key_exists($name, $this->_extendAttributes);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['title', 'category_id', 'content'], 'required'],
            [['status', 'category_id', 'view', 'is_top'], 'integer'],
            [['category_id', 'status', 'view'], 'filter', 'filter' => 'intval'],
            ['published_at', 'string'],
            ['published_at', 'default', 'value' => date('Y-m-d H:i:s')],
            ['category_id', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 50],
            [['cover', 'source', 'desc'], 'string', 'max' => 255],
            [['tagNames'], 'string']
        ];
        if ($this->moduleClass) {
            $rules = array_merge($rules, $this->moduleClass->rules());
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('common', 'ID'),
            'title' => '标题',
            'content' => '内容',
            'deleted_at' => '删除时间',
            'published_at' => '发布时间',
            'status' => '审核',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
            'source' => '来源连接',
            'desc' => '摘要',
            'tagNames' => '标签',
            'user_id' => '作者',
            'view' => '浏览量',
            'is_top' => '是否置顶'
        ];
        if ($this->moduleClass) {
            $labels = array_merge($labels, $this->moduleClass->attributeLabels());
        }
        return $labels;
    }
    public function attributeHints()
    {
        return [
            'desc' => '（默认截取内容前150个字符）',
            'tagNames' => '（空格分隔多个标签）'
        ];
    }

    public function attributeTypes()
    {
        return $this->moduleClass->attributeTypes();
    }

    public function getAttributeType($attribute)
    {
        $types = $this->attributeTypes();
        return isset($types[$attribute]) ? $types[$attribute] : 'text';
    }

    public function getIsNewRecord()
    {
        return $this->_isNewRecord;
    }

    public function store()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $article = new Article();
                $article->title = $this->title;
                $article->cover = $this->cover;
                $article->source = $this->source;
                $article->view = (int)$this->view;
                $article->is_top = $this->is_top;
                $article->category_id = $this->category_id;
                $article->status = $this->status;
                $article->desc = $this->desc;
                $article->published_at = strtotime($this->published_at);
                $article->save();
                $articleData = new ArticleData();
                $articleData->content = $this->content;
                $articleData->id = $article->id;
                $articleData->save();
                $this->setTags($article);
                if ($this->moduleClass) {
                    $this->moduleClass->attributes = $this->_extendAttributes;
                    $this->moduleClass->id = $article->id;
                    $this->moduleClass->insert();
                }
                $transaction->commit();
                return true;
            }catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }
        return false;
    }

    public function update()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $article = Article::findOne($this->id);
                $article->title = $this->title;
                $article->cover = $this->cover;
                $article->source = $this->source;
                $article->view = (int)$this->view;
                $article->is_top = $this->is_top;
                $article->category_id = $this->category_id;
                $article->status = $this->status;
                $article->desc = $this->desc;
                $article->published_at = strtotime($this->published_at);
                $article->save();
                $articleData = $article->data;
                $articleData->content = $this->content;
                $articleData->save();
                $this->setTags($article);
                if ($this->moduleClass) {
                    $this->moduleClass->attributes = $this->_extendAttributes;
                    $this->moduleClass->id = $article->id;
                    $this->moduleClass->update();
                }
                $transaction->commit();
                return true;
            }catch (\Exception $e) {
                echo $e->getMessage();die;
                $transaction->rollBack();
                return false;
            }
        }
        return false;
    }

    public function setTags($article)
    {
        // 先清除文章所有标签
        ArticleTag::deleteAll(['article_id' => $article->id]);
        // 更新原标签文章数
        $oldTags = explode(' ', $this->tagNames);
        Tag::updateAllCounters(['article' => -1], ['name' => $oldTags]);
        if (!empty($this->tagNames)) {
            $tags = explode(' ', $this->tagNames);
            foreach($tags as $tag) {
                $tagModel = Tag::findOne(['name' => $tag]);
                if (empty($tagModel)) {
                    $tagModel = new Tag();
                    $tagModel->name = $tag;
                    $tagModel->save();
                }
                $articleTag = new ArticleTag();
                $articleTag->article_id = $article->id;
                $articleTag->tag_id = $tagModel->id;
                $articleTag->save();
            }
            Tag::updateAllCounters(['article' => 1], ['name' => $tags]);
        }
    }

    public function getId()
    {
        return $this->_id;
    }
    public static function findOne($id)
    {
        $article = Article::find()->where(['id' => $id])->with('data')->one();
        $model = new self($article->module);
        // 不能保证一定有扩展
        if ($article->extend) {
            $model->moduleClass = $article->extend;
            $model->_extendAttributes = $model->moduleClass->attributes;
        }
        $model->title = $article->title;
        $model->cover = $article->cover;
        $model->view = $article->view;
        $model->is_top = $article->is_top;
        $model->source = $article->source;
        $model->category_id = $article->category_id;
        $model->status = $article->status;
        $model->desc = $article->desc;
        $model->published_at = date('Y-m-d H:i:s', $article->published_at);
        $model->content = $article->data->content;
        $model->tagNames = $article->getTagNames();
        $model->_isNewRecord = false;
        $model->_id = $article->id;
        return $model;
    }
}