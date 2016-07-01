<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 上午11:21
 */

namespace frontend\events;


use yii\base\Event;

class NavEvent extends Event
{
    public $items;
}