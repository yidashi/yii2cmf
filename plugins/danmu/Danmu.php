<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:31
 */

namespace plugins\danmu;

class Danmu
{
    public static function handle($event)
    {
        echo DanmuWidget::widget([
            'entity' => $event->entity,
            'entityId' => $event->entityId
        ]);
    }
}