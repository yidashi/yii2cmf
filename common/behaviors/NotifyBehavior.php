<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/12
 * Time: 下午4:49
 */

namespace common\behaviors;


use common\models\Article;
use common\models\Comment;
use common\models\Reward;
use common\models\Suggest;
use common\models\Vote;
use common\traits\EntityTrait;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Markdown;
use yii\helpers\StringHelper;
use yii\web\Application;

class NotifyBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'bindEvent',
        ];
    }

    public function bindEvent($event)
    {
        Event::on(ActiveRecord::className(), 'afterInsert', [$this, 'afterInsert']);
    }

    public function afterInsert($event)
    {
        $entity = get_class($event->sender);
        switch ($entity) {
            case 'common\models\Comment':
                $fromUid = $event->sender->user_id;
                // 如果是回复,发站内信,通知什么的
                if ($event->sender->parent_id > 0) {
                    $toUid = $event->sender->reply_uid ?: $event->sender->parent->user_id;
                    $category = 'reply';
                    $extra = [
                        'entity' => $event->sender->entity,
                        'entity_id' => $event->sender->entity_id,
                        'comment_id' => $event->sender->id,
                        'comment' => $this->generateMsgContent($event->sender->content)
                    ];
                } else {
                    switch ($event->sender->entity) {
                        case 'common\models\Article':
                            $category = 'comment_article';
                            $article = Article::findOne($event->sender->entity_id);
                            $toUid = $article->user_id;
                            $extra = [
                                'comment' => $this->generateMsgContent($event->sender->content),
                                'comment_id' => $event->sender->id,
                                'entity' => $event->sender->entity,
                                'entity_title' => $article->title,
                                'entity_id' => $article->id
                            ];
                            break;
                        case 'common\models\Suggest':
                            $category = 'comment_suggest';
                            $suggest = Suggest::findOne($event->sender->entity_id);
                            $toUid = $suggest->user_id;
                            $extra = [
                                'comment' => $this->generateMsgContent($event->sender->content),
                                'comment_id' => $event->sender->id,
                                'entity' => $event->sender->entity,
                                'entity_title' => $suggest->title,
                                'entity_id' => $event->sender->entity_id
                            ];
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
                    ->send();
                break;
            case 'common\models\Suggest':
                $category = 'suggest';
                $fromUid = $event->sender->user_id;
                $toUid = 1; // 先写死
                $extra = [
                    'title' => $this->generateMsgContent($event->sender->content),
                    'entity_id' => $event->sender->id
                ];
                Yii::$app->notify->category($category)
                    ->from($fromUid)
                    ->to($toUid)
                    ->extra($extra)
                    ->send();
                break;
            case 'common\models\Vote':
                // 赞才发通知
                if ($event->sender->action == Vote::ACTION_UP) {
                    $fromUid = $event->sender->user_id;
                    switch ($event->sender->entity) {
                        case 'common\models\Article':
                            $category = 'up_article';
                            $article = Article::findOne($event->sender->entity_id);
                            $toUid = $article->user_id;
                            $extra = [
                                'entity_title' => $article->title,
                                'entity_id' => $article->id
                            ];
                            break;
                        case 'common\models\Comment':
                            $category = 'up_comment';
                            $comment = Comment::findOne($event->sender->entity_id);
                            $toUid = $comment->user_id;
                            $extra = [
                                'comment_title' => $this->generateMsgContent($comment->content),
                                'comment_id' => $comment->id,
                                'entity' => $comment->entity,
                                'entity_id' => $comment->entity_id
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
                        ->send();
                }
                break;
            case 'common\models\Favourite':
                $article = $event->sender->article;
                $fromUid = $event->sender->user_id;
                $toUid = $article->user_id;
                $extra = [
                    'entity_title' => $article->title,
                    'entity_id' => $article->id
                ];
                Yii::$app->notify->category('favourite')
                    ->from($fromUid)
                    ->to($toUid)
                    ->extra($extra)
                    ->send();
                break;
            case 'common\\modules\\message\\models\\Message':
                Yii::$app->notify->category('message')
                    ->from($event->sender->from_uid)
                    ->to($event->sender->to_uid)
                    ->extra(['message' => $event->sender->data->content])
                    ->send();
                break;
            case 'common\\models\\Reward':
                $article = $event->sender->article;
                Yii::$app->notify->category('reward')
                    ->from($event->sender->user_id)
                    ->to($article->user_id)
                    ->extra([
                        'article_title' => $article->title,
                        'article_id' => $article->id,
                        'money' => $event->sender->money,
                        'comment' => $event->sender->comment
                    ])
                    ->send();
                break;
            case 'common\\models\\Friend':
                Yii::$app->notify->category('follow')
                    ->from($event->sender->owner_id)
                    ->to($event->sender->friend_id)
                    ->send();
                break;
        }

    }
    private function generateMsgContent($content)
    {
        return StringHelper::truncate(preg_replace('/\s+/', ' ', strip_tags(Markdown::process($content))), 50);
    }
}