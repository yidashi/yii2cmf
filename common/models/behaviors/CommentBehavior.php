<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午8:48
 */

namespace common\models\behaviors;


use common\helpers\Html;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use common\models\Article;
use Yii;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;

class CommentBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'decreaseComment'
        ];
    }
    public function afterInsert($event)
    {
        $this->sendNotify($event);
        $this->increaseComment($event);
    }
    public function sendNotify($event)
    {
        $fromUid = $event->sender->user_id;
        // 如果是回复,发站内信,通知什么的
        if ($event->sender->parent_id > 0) {
            $toUid = $event->sender->parent->user_id;
            $extra = ['comment' => $this->generateMsgContent($event->sender->content)];
            switch ($event->sender->type) {
                case 'article':
                    $category = 'reply';
                    $link = Url::to(['/article/view', 'id' => $event->sender->type_id, '#' => 'comment-' . $event->sender->id]);
                    break;
                case 'suggest':
                    $category = 'suggest';
                    $link = Url::to(['/suggest', '#' => 'suggest-' . $event->sender->id]);
                    break;
                default:
                    return;
                    break;
            }
        } else {
            switch ($event->sender->type) {
                case 'article':
                    $category = 'comment';
                    $article = Article::find()->where(['id' => $event->sender->type_id])->one();
                    $toUid = $article->user_id;
                    $extra = [
                        'comment' => $this->generateMsgContent($event->sender->content),
                        'article_title' => Html::a($article->title, ['/article/view', 'id' => $article->id])
                    ];
                    $link = Url::to(['/article/view', 'id' => $event->sender->type_id, '#' => 'comment-' . $event->sender->id]);
                    break;
                case 'suggest':
                    $category = 'suggest';
                    $toUid = 1; // 先写死
                    $extra = [
                        'comment' => $this->generateMsgContent($event->sender->content),
                    ];
                    $link = Url::to(['/suggest', 'id' => $event->sender->type_id, '#' => 'comment-' . $event->sender->id]);
                    break;
                default:
                    return;
                    break;
            }
        }
        Yii::$app->notify->category($category)
            ->from($fromUid)
            ->to($toUid)
            ->extra($extra)
            ->link($link)
            ->send();
    }
    private function generateMsgContent($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags(Markdown::process($content, 'gfm'))), 50);
    }

    /**
     * 更新文章评论计数器等.
     */
    public function increaseComment($event)
    {
        if ($event->sender->type == 'article') {
            Article::updateAllCounters(['comment' => 1], ['id' => $event->sender->type_id]);
        }
    }

    public function decreaseComment($event)
    {
        if ($event->sender->type == 'article') {
            Article::updateAllCounters(['comment' => -1], ['id' => $event->sender->type_id]);
        }
    }
}