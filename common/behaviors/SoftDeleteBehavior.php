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
use yii\db\Expression;

/**
 * 把默认删除改成软删除,彻底删除用hardDelete方法
 * Class SoftDeleteBehavior
 * @package common\behaviors
 */
class SoftDeleteBehavior extends Behavior
{
    public $deletedAttribute = 'deleted_at';
    public $value;
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'softDelete',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : time();
        }
    }
    public function softDelete($event)
    {
        $event->sender->setAttribute($this->deletedAttribute, $this->getValue(null));
        $event->sender->save(false);
        $event->isValid = false;
    }

    public function hardDelete()
    {
        $this->owner->off(BaseActiveRecord::EVENT_BEFORE_DELETE, [$this,'softDelete']);
        return $this->owner->delete();
    }
}