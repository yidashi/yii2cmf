<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/29
 * Time: 上午11:15
 */

namespace common\listeners;


class ViewArticleListener
{
    public static function handle($event)
    {
        /* @var $model \common\models\Article */
        $model = $event->model;
        // 浏览量变化
        $model->addView();
    }
}