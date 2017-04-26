<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/10/26 10:30
 * Description:
 */

namespace frontend\widgets\comment;


use yii\base\Event;

class CommentEvent extends Event
{
    public $entity;

    public $entityId;
}