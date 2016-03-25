<?php

namespace common\models;

use common\behaviors\AfterFindArticleBehavior;
use common\behaviors\PushBehavior;
use common\behaviors\SoftDeleteBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['title'], 'required'],
            [['status', 'category_id', 'view', 'up', 'down', 'user_id'], 'integer'],
            [['category_id', 'status'], 'filter', 'filter' => 'intval'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INIT]],
            [['category_id'], 'setCategory'],
            [['title', 'category', 'author'], 'string', 'max' => 50],
            [['author', 'cover'], 'string', 'max' => 255],
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
            'id' => Yii::t('app', 'ID'),
            'title' => '标题',
            'author' => '作者',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => '删除时间',
            'status' => '状态',
            'cover' => '封面',
            'category_id' => '分类',
            'category' => '分类',
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
     * 不包含软删除的
     * @return $this
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
            self::SCENARIO_DEFAULT => self::OP_DELETE,
        ];
    }

    /**
     * 绑定写入后的事件.
     */
    public function init()
    {
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteContent']);
    }

    public function deleteContent($event)
    {
        $content = ArticleData::findOne(['id' => $event->sender->id]);
        if ($content) {
            $content->delete();
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

    public function getTrueView()
    {
        return $this->view + \Yii::$app->cache->get('article:view:' . $this->id);
    }

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
        if ($view !== false && $view >= 20) {
            $this->view = $this->view + $view;
            $this->save(false);
            $cache->delete($key);
        } else {
            $cache->set($key, 1);
        }
    }
}
