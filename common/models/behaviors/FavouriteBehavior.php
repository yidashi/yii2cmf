<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午8:54
 */

namespace common\models\behaviors;


use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class FavouriteBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'sendNotify'
        ];
    }

    public function sendNotify($event)
    {
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
    }
}