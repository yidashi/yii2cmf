<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午9:15
 */

namespace common\models\behaviors;

use frontend\models\Search;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Article;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;


class ArticleDataBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => [$this, 'afterSaveInternal'],
            ActiveRecord::EVENT_AFTER_UPDATE => [$this, 'afterSaveInternal']
        ];
    }

    /**
     * 发布新文章后（摘要为空的话根据内容生成摘要)
     */
    public function afterSaveInternal($event)
    {
        $article = Article::findOne(['id' => $event->sender->id]);
        if (!empty($article)) {
            if (empty($article->description)) {
                $article->description = $this->generateDesc($event->sender->processedContent);
                $article->save();
            }
        }
    }

    /**
     * 摘要生成方式
     */
    private function generateDesc($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags($content)), 150);
    }
}