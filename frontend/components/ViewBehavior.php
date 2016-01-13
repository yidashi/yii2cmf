<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30
 */

namespace frontend\components;


use common\widgets\share\Share;
use yii\base\Behavior;
use yii\web\View;

class ViewBehavior extends Behavior
{
    public function events()
    {
        return [
            View::EVENT_END_BODY => 'onEndBody'
        ];
    }

    public function onEndBody($event)
    {
//        echo Share::widget();
    }
}