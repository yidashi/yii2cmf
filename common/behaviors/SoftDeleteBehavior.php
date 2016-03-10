<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/10
 * Time: 上午11:50
 */

namespace common\behaviors;


use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class SoftDeleteBehavior extends Behavior
{
    public $deletedAttribute = 'deleted_at';
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'softDelete',
        ];
    }

    public function softDelete($event)
    {
        $event->sender->setAttribute($this->deletedAttribute, time());
        $event->sender->save(false);
        $event->isValid = false;
    }
}