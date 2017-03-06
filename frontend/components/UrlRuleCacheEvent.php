<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/6
 * Time: 下午11:57
 */

namespace frontend\components;


use yii\base\Event;

class UrlRuleCacheEvent extends Event
{
    public $ruleCache;

    public $urlManager;

}