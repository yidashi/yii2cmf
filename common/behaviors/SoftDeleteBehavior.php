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
    public function softDelete()
    {
        $this->owner->setAttribute($this->deletedAttribute, $this->getValue(null));
        return $this->owner->save(false);
    }
}