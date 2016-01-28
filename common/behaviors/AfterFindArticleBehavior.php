<?php
/**
 * author: yidashi
 * Date: 2015/12/31
 * Time: 16:27.
 */
namespace common\behaviors;

use common\models\Article;
use yii\base\Behavior;

class AfterFindArticleBehavior extends Behavior
{
    public function events()
    {
        return [Article::EVENT_AFTER_FIND => 'run'];
    }

    /**
     * 查出来处理一下.
     *
     * @param $event
     */
    public function run($event)
    {
        $model = $event->sender;
        $rawCover = $model->cover;
        $cover = $rawCover ? (strpos($rawCover, 'http://') === false ? (\Yii::getAlias('@static').'/'.$rawCover) : $rawCover) : 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png';
        $model->cover = $cover;
        $redis = \Yii::$app->redis;
        $rkey = 'article:view:'.$model->id;
        $model->view += $redis->get($rkey);
        $event->sender = $model;
    }
}
