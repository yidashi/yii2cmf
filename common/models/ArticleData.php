<?php

namespace common\models;
use yii\helpers\Markdown;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%article_data}}".
 *
 * @property int $id
 * @property string $content
 */
class ArticleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
        ];
    }
    /**
     * 绑定写入后的事件.
     */
    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'afterSaveInternal']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'afterSaveInternal']);
    }

    /**
     * 发布新文章后（摘要为空的话根据内容生成摘要)
     */
    public function afterSaveInternal($event)
    {
        $article = Article::findOne(['id' => $event->sender->id]);
        if (empty($article->desc)) {
            $article->desc = $this->generateDesc($event->sender->content);
            $article->save(false);
        }
    }

    /**
     * 摘要生成方式
     */
    private function generateDesc($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags(Markdown::process($content, 'gfm'))), 150);
    }
}
