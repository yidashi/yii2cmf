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
 * 添加该行为可以附加软删除功能（不真的删除,只是改变deletedAttribute值）
 * Class SoftDeleteBehavior
 * @package common\behaviors
 */
class SoftDeleteBehavior extends Behavior
{
    public $deletedAttribute = 'deleted_at';
    public $value;
    const EVENT_AFTER_SOFT_DELETE = 'afterSoftDelete';
    const EVENT_AFTER_REDUCTION = 'afterReduction';
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

    /**
     * 软删除
     */
    public function softDelete()
    {
        $this->owner->setAttribute($this->deletedAttribute, $this->getValue(null));
        if ($this->owner->save(false)) {
            $this->owner->trigger(self::EVENT_AFTER_SOFT_DELETE);
            return true;
        }
        return false;
    }

    /**
     * 还原
     */
    public function reduction()
    {
        $this->owner->setAttribute($this->deletedAttribute, 0);
        if ($this->owner->save(false)) {
            $this->owner->trigger(self::EVENT_AFTER_REDUCTION);
            return true;
        }
        return false;
    }
}