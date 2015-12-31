<?php
/**
 * author: yidashi
 * Date: 2015/12/31
 * Time: 16:27
 */

namespace common\behaviors;


use common\models\Article;
use yii\base\Behavior;

class ShowCoverBehavior extends Behavior
{
    public function events()
    {
        return [Article::EVENT_AFTER_FIND => 'showCover'];
    }
    public function showCover($event)
    {
        $rawCover = $event->sender->cover;
        $cover = $rawCover ? ( strpos($rawCover, 'http://') === false ? (\Yii::getAlias('@static') . '/' . $rawCover) : $rawCover) : 'http://www.tiejiong.com/uploads/allimg/c151206/14493S94614C0-4Ic7.png';
        $event->sender->cover = $cover;
    }
}