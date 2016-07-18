<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/29
 * Time: 上午11:13
 */

namespace common\events;


use yii\base\Event;

class ArticleEvent extends Event
{
    public $model;
}