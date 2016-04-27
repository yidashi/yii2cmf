<?php

namespace common\models;

use common\behaviors\PushBehavior;
use common\behaviors\SoftDeleteBehavior;
use common\models\query\ArticleQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $cover
 */
class Article extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INIT = 0;

    private $_tagNames;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['status', 'category_id', 'view', 'up', 'down', 'user_id'], 'integer'],
            [['category_id', 'status'], 'filter', 'filter' => 'intval'],
            ['published_at', 'default', 'value' => time()],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INIT]],
            [['category_id'], 'setCategory'],
            ['category_id', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id'],
            [['title', 'category', 'author'], 'string', 'max' => 50],
            [['author', 'cover', 'source'], 'string', 'max' => 255],
            [['desc', 'tagNames'], 'safe']
        ];
    }
    public function setCategory($attribute, $params)
    {
        $this->category = Category::find()->where(['id' => $this->$attribute])->select('title')->scalar();
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => '标题',
            'author' => '作者',
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'deleted_at' => '删除时间',
            'published_at' => '发布时间',
            'status' => '状态',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
            'source' => '来源连接',
            'desc' => '摘要',
            'tagNames' => '标签'
        ];
    }
    public function attributeHints()
    {
        return [
            'desc' => '（默认截取内容前150个字符）',
            'tagNames' => '（空格分隔多个标签）'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            PushBehavior::className(),
            SoftDeleteBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(ArticleQuery::className(), [get_called_class()]);
    }

    /**
     * 事务关联删除
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * 绑定写入后的事件.
     */
    public function init()
    {
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteContent']);
        $this->on(SoftDeleteBehavior::EVENT_AFTER_SOFT_DELETE, [$this, 'afterSoftDeleteInternal']);
        $this->on(SoftDeleteBehavior::EVENT_AFTER_REDUCTION, [$this, 'afterReductionInternal']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'afterInsertInternal']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterUpdateInternal']);
    }

    /**
     * 删除文章内容
     */
    public function deleteContent($event)
    {
        $content = ArticleData::findOne(['id' => $event->sender->id]);
        if ($content) {
            $content->delete();
        }
    }
    /**
     * 软删除文章后（更新分类文章数)
     */
    public function afterSoftDeleteInternal($event)
    {
        Category::updateAllCounters(['article' => -1], ['id' => $event->sender->category_id]);
    }
    /**
     * 软删除文章还原后（更新分类文章数)
     */
    public function afterReductionInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
    }
    /**
     * 发布新文章后（更新分类文章数)
     */
    public function afterInsertInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
    }
    /**
     * 修改文章后（如果修改了分类,更新分类文章数)
     */
    public function afterUpdateInternal($event) {
        $changedAttributes = $event->changedAttributes;
        if (isset($changedAttributes['category_id'])) {
            Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
            Category::updateAllCounters(['article' => -1], ['id' => $changedAttributes['category_id']]);
        }
    }
    public function getData()
    {
        return $this->hasOne(ArticleData::className(), ['id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }

    /**
     * 真实浏览量
     */
    public function getTrueView()
    {
        return $this->view + \Yii::$app->cache->get('article:view:' . $this->id);
    }

    /**
     * 封面绝对地址
     */
    public function getAbsoluteCover()
    {
        return $this->cover ? (strpos($this->cover, 'http://') === false ? (\Yii::getAlias('@static').'/' . $this->cover) : $this->cover) : 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png';
    }
    /**
     * 增加浏览量
     */
    public function addView()
    {
        $cache = \Yii::$app->cache;
        $key = 'article:view:'.$this->id;
        $view = $cache->get($key);
        if ($view !== false) {
            if ($view >= 20) {
                $this->view = $this->view + $view + 1;
                $this->save(false);
                $cache->delete($key);
            } else {
                $cache->set($key, ++$view);
            }
        } else {
            $cache->set($key, 1);
        }
    }
    public function getTagNames()
    {
        $tags = $this->tags;
        if (!empty($tags)) {
            $tagNames = [];
            foreach($tags as $tag) {
                $tagNames[] = $tag->name;
            }
            $tagNames = join(' ', $tagNames);
        } else {
            $tagNames = '';
        }
        return $tagNames;
    }

    public function setTagNames($value)
    {
        $this->_tagNames = $value;
        return $this->_tagNames;
    }
    public function setTags()
    {
        // 先清除文章所有标签
        ArticleTag::deleteAll(['article_id' => $this->id]);
        // 更新原标签文章数
        $oldTags = explode(' ', $this->tagNames);
        Tag::updateAllCounters(['article' => -1], ['name' => $oldTags]);
        if (!empty($this->_tagNames)) {
            $tags = explode(' ', $this->_tagNames);
            foreach($tags as $tag) {
                $tagModel = Tag::findOne(['name' => $tag]);
                if (empty($tagModel)) {
                    $tagModel = new Tag();
                    $tagModel->name = $tag;
                    $tagModel->save();
                }
                $articleTag = new ArticleTag();
                $articleTag->article_id = $this->id;
                $articleTag->tag_id = $tagModel->id;
                $articleTag->save();
            }
            Tag::updateAllCounters(['article' => 1], ['name' => $tags]);
        }
    }

    public function getIsFavourite()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $favourite = Favourite::find()->where(['article_id' => $this->id, 'user_id' => $userId])->one();
            if ($favourite) {
                return true;
            }
        }
        return false;
    }

    public function getIsUp()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $up = Vote::find()->where(['type' => 'article', 'type_id' => $this->id, 'user_id' => $userId, 'action' => 'up'])->one();
            if ($up) {
                return true;
            }
        }
        return false;
    }

    public function getIsDown()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $down = Vote::find()->where(['type' => 'article', 'type_id' => $this->id, 'user_id' => $userId, 'action' => 'down'])->one();
            if ($down) {
                return true;
            }
        }
        return false;
    }
}
