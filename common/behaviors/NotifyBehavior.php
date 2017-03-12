<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/12
 * Time: 下午4:49
 */

namespace common\behaviors;


use common\models\Article;
use common\traits\EntityTrait;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use common\models\Vote;
use common\models\Favourite;

class NotifyBehavior extends Behavior
{
    use EntityTrait;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ];
    }

    public function afterInsert($event)
    {
        $entity = $this->getEntity();
        switch ($entity) {
            case 'common\models\Comment':
                $fromUid = $event->sender->user_id;
                // 如果是回复,发站内信,通知什么的
                if ($event->sender->parent_id > 0) {
                    $toUid = $event->sender->reply_uid ?: $event->sender->parent->user_id;
                    $extra = ['comment' => $this->generateMsgContent($event->sender->content)];
                    switch ($event->sender->entity) {
                        case 'common\models\Article':
                            $category = 'reply';
                            $link = Url::to(['/article/view', 'id' => $event->sender->entity_id, '#' => 'comment-' . $event->sender->id]);
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
                    switch ($event->sender->entity) {
                        case 'common\models\Article':
                            $category = 'comment';
                            $article = Article::find()->where(['id' => $event->sender->entity_id])->one();
                            $toUid = $article->user_id;
                            $extra = [
                                'comment' => $this->generateMsgContent($event->sender->content),
                                'article_title' => Html::a($article->title, ['/article/view', 'id' => $article->id])
                            ];
                            $link = Url::to(['/article/view', 'id' => $event->sender->entity_id, '#' => 'comment-' . $event->sender->id]);
                            break;
                        case 'suggest':
                            $category = 'suggest';
                            $toUid = 1; // 先写死
                            $extra = [
                                'comment' => $this->generateMsgContent($event->sender->content),
                            ];
                            $link = Url::to(['/suggest', 'id' => $event->sender->entity_id, '#' => 'comment-' . $event->sender->id]);
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
                break;
            case 'common\models\Vote':
                // 赞才发通知
                if ($event->sender->action == Vote::ACTION_UP) {
                    $fromUid = $event->sender->user_id;
                    switch ($event->sender->entity) {
                        case 'common\models\Article':
                            $category = 'up_article';
                            $article = $event->sender->article;
                            $toUid = $article->user_id;
                            $extra = [
                                'article_title' => Html::a($article->title, ['/article/view', 'id' => $article->id])
                            ];
                            break;
                        default:
                            return;
                            break;
                    }
                    \Yii::$app->notify->category($category)
                        ->from($fromUid)
                        ->to($toUid)
                        ->extra($extra)
                        ->link(url(['/article/view', 'id' => $article->id]))
                        ->send();
                }
                break;
            case 'common\models\Favourite':
                $category = 'favourite';
                $article = $event->sender->article;
                $fromUid = $event->sender->user_id;
                $toUid = $article->user_id;
                $extra = [
                    'article_title' => Html::a($article->title, ['/article/view', 'id' => $article->id])
                ];
                Yii::$app->notify->category($category)
                    ->from($fromUid)
                    ->to($toUid)
                    ->extra($extra)
                    ->link(url(['/article/view', 'id' => $article->id]))
                    ->send();
                break;
        }

    }
    private function generateMsgContent($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags(Markdown::process($content))), 50);
    }
}