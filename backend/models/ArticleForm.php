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
use common\models\ArticleTag;
use common\models\Tag;
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

    private $_isNewRecord = true;
    private $_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'content'], 'required'],
            [['status', 'category_id', 'view', 'is_top'], 'integer'],
            [['category_id', 'status'], 'filter', 'filter' => 'intval'],
            ['published_at', 'string'],
            ['published_at', 'default', 'value' => date('Y-m-d H:i:s')],
            ['category_id', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 50],
            [['cover', 'source', 'desc'], 'string', 'max' => 255],
            [['tagNames'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
    }
    public function attributeHints()
    {
        return [
            'desc' => '（默认截取内容前150个字符）',
            'tagNames' => '（空格分隔多个标签）'
        ];
    }

    public function getIsNewRecord()
    {
        return $this->_isNewRecord;
    }

    public function store()
    {
        if ($this->validate()) {
            $article = new Article();
            $article->title = $this->title;
            $article->cover = $this->cover;
            $article->view = (int) $this->view;
            $article->is_top = $this->is_top;
            $article->category_id = $this->category_id;
            $article->status = $this->status;
            $article->published_at = strtotime($this->published_at);
            $article->save();
            $articleData = new ArticleData();
            $articleData->content = $this->content;
            $articleData->id = $article->id;
            $articleData->save();
            $this->setTags($article);
            return true;
        }
        return false;
    }

    public function update()
    {
        if ($this->validate()) {
            $article = Article::findOne($this->id);
            $article->title = $this->title;
            $article->cover = $this->cover;
            $article->view = (int) $this->view;
            $article->is_top = $this->is_top;
            $article->category_id = $this->category_id;
            $article->status = $this->status;
            $article->published_at = strtotime($this->published_at);
            $article->save();
            $articleData = $article->data;
            $articleData->content = $this->content;
            $articleData->save();
            $this->setTags($article);
            return true;
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
        $model = new self();
        $model->title = $article->title;
        $model->cover = $article->cover;
        $model->view = $article->view;
        $model->is_top = $article->is_top;
        $model->category_id = $article->category_id;
        $model->status = $article->status;
        $model->published_at = date('Y-m-d H:i:s', $article->published_at);
        $model->content = $article->data->content;
        $model->tagNames = $article->getTagNames();
        $model->_isNewRecord = false;
        $model->_id = $article->id;
        return $model;
    }
}