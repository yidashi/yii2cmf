<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午9:29
 */

namespace frontend\models;


use common\models\Article;
use common\models\ArticleData;
use common\models\ArticleTag;
use common\models\Tag;
use yii\base\Model;
use Yii;
use common\models\Category;
use yii\web\NotFoundHttpException;

class ArticleForm extends Model
{
    public $tagNames;
    public $title;
    public $content;
    public $cover;
    public $category_id;
    public $source;
    public $status = 0;
    public $published_at;
    public $desc;

    private $_isNewRecord = true;
    private $_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'content'], 'required'],
            [['category_id'], 'integer'],
            [['category_id', 'status'], 'filter', 'filter' => 'intval'],
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
            'published_at' => '发布时间',
            'status' => '审核',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
            'source' => '来源连接',
            'desc' => '摘要',
            'tagNames' => '标签',
            'user_id' => '作者',
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
            $article->category_id = $this->category_id;
            $article->status = $this->status;
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
            $article->category_id = $this->category_id;
            $article->status = $this->status;
            $article->published_at = $this->published_at;
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
        $article = Article::find()->where(['id' => $id])->my()->with('data')->one();
        if (empty($article)) {
            throw new NotFoundHttpException('文章不存在或者不属于你');
        }
        $model = new self();
        $model->title = $article->title;
        $model->cover = $article->cover;
        $model->category_id = $article->category_id;
        $model->status = $article->status;
        $model->published_at = $article->published_at;
        $model->content = $article->data->content;
        $model->tagNames = $article->getTagNames();
        $model->_isNewRecord = false;
        $model->_id = $article->id;
        return $model;
    }
}