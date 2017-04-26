<?php
namespace common\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;

/**
 * SoftDeleteBehavior provides support for "soft" delete of ActiveRecord models as well as restoring them
 * from "deleted" state.
 *
 * ```php
 * class Item extends ActiveRecord
 * {
 *     public function behaviors()
 *     {
 *         return [
 *             'softDeleteBehavior' => [
 *                 'class' => SoftDeleteBehavior::className(),
 *                 'softDeleteAttributeValues' => [
 *                     'isDeleted' => true
 *                 ],
 *             ],
 *         ];
 *     }
 * }
 * ```
 *
 * @property BaseActiveRecord $owner owner ActiveRecord instance.
 * @property boolean $replaceRegularDelete whether to perform soft delete instead of regular delete.
 * If enabled [[BaseActiveRecord::delete()]] will perform soft deletion instead of actual record deleting.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class SoftDeleteBehavior extends Behavior
{
    /**
     * @event ModelEvent an event that is triggered before deleting a record.
     * You may set [[ModelEvent::isValid]] to be false to stop the deletion.
     */
    const EVENT_BEFORE_SOFT_DELETE = 'beforeSoftDelete';
    /**
     * @event Event an event that is triggered after a record is deleted.
     */
    const EVENT_AFTER_SOFT_DELETE = 'afterSoftDelete';
    /**
     * @event ModelEvent an event that is triggered before record is restored from "deleted" state.
     * You may set [[ModelEvent::isValid]] to be false to stop the restoration.
     */
    const EVENT_BEFORE_RESTORE = 'beforeRestore';
    /**
     * @event Event an event that is triggered after a record is restored from "deleted" state.
     */
    const EVENT_AFTER_RESTORE = 'afterRestore';
    /**
     * @var array values of the owner attributes, which should be applied on soft delete, in format: [attributeName => attributeValue].
     * Those may raise a flag:
     *
     * ```php
     * ['isDeleted' => true]
     * ```
     *
     * or switch status:
     *
     * ```php
     * ['statusId' => Item::STATUS_DELETED]
     * ```
     *
     * Attribute value can be a callable:
     *
     * ```php
     * ['isDeleted' => function ($model) {return time()}]
     * ```
     */
    public $softDeleteAttributeValues = [
        'isDeleted' => true
    ];
    /**
     * @var array|null  values of the owner attributes, which should be applied on restoration from "deleted" state,
     * in format: [attributeName => attributeValue]. If not set value will be automatically detected from [[softDeleteAttributeValues]].
     */
    public $restoreAttributeValues;
    /**
     * @var boolean whether to invoke owner [[BaseActiveRecord::beforeDelete()]] and [[BaseActiveRecord::afterDelete()]]
     * while performing soft delete. This option affects only [[softDelete()]] method.
     */
    public $invokeDeleteEvents = true;
    /**
     * @var callable|null callback, which execution determines if record should be "hard" deleted instead of being marked
     * as deleted. Callback should match following signature: `boolean function(BaseActiveRecord $model)`
     * For example:
     *
     * ```php
     * function ($user) {
     *     return $user->lastLoginDate === null;
     * }
     * ```
     */
    public $allowDeleteCallback;
    /**
     * @var string class name of the exception, which should trigger a fallback to [[softDelete()]] method from [[safeDelete()]].
     * By default [[\yii\db\IntegrityException]] is used, which means soft deleting will be performed on foreign constraint
     * violation DB exception.
     * You may specify another exception class here to customize fallback error level. For example: usage of [[\Exception]]
     * will cause soft-delete fallback on any error during regular deleting.
     * @see safeDelete()
     */
    public $deleteFallbackException = 'yii\db\IntegrityException';
    /**
     * @var boolean whether to perform soft delete instead of regular delete.
     * If enabled [[BaseActiveRecord::delete()]] will perform soft deletion instead of actual record deleting.
     */
    private $_replaceRegularDelete = false;
    /**
     * @return boolean
     */
    public function getReplaceRegularDelete()
    {
        return $this->_replaceRegularDelete;
    }
    /**
     * @param boolean $replaceRegularDelete
     */
    public function setReplaceRegularDelete($replaceRegularDelete)
    {
        $this->_replaceRegularDelete = $replaceRegularDelete;
        if (is_object($this->owner)) {
            $owner = $this->owner;
            $this->detach();
            $this->attach($owner);
        }
    }
    /**
     * Marks the owner as deleted.
     * @return integer|false the number of rows marked as deleted, or false if the soft deletion is unsuccessful for some reason.
     * Note that it is possible the number of rows deleted is 0, even though the soft deletion execution is successful.
     */
    public function softDelete()
    {
        if ($this->isDeleteAllowed()) {
            return $this->owner->delete();
        }
        if ($this->invokeDeleteEvents && !$this->owner->beforeDelete()) {
            return false;
        }
        $result = $this->softDeleteInternal();
        if ($this->invokeDeleteEvents) {
            $this->owner->afterDelete();
        }
        return $result;
    }
    /**
     * Marks the owner as deleted.
     * @return integer|false the number of rows marked as deleted, or false if the soft deletion is unsuccessful for some reason.
     */
    protected function softDeleteInternal()
    {
        $result = false;
        if ($this->beforeSoftDelete()) {
            $attributes = [];
            foreach ($this->softDeleteAttributeValues as $attribute => $value) {
                if (!is_scalar($value) && is_callable($value)) {
                    $value = call_user_func($value, $this->owner);
                }
                $attributes[$attribute] = $value;
            }
            $result = $this->owner->updateAttributes($attributes);
            $this->afterSoftDelete();
        }
        return $result;
    }
    /**
     * This method is invoked before soft deleting a record.
     * The default implementation raises the [[EVENT_BEFORE_SOFT_DELETE]] event.
     * @return boolean whether the record should be deleted. Defaults to true.
     */
    public function beforeSoftDelete()
    {
        if (method_exists($this->owner, 'beforeSoftDelete')) {
            if (!$this->owner->beforeSoftDelete()) {
                return false;
            }
        }
        $event = new ModelEvent();
        $this->owner->trigger(self::EVENT_BEFORE_SOFT_DELETE, $event);
        return $event->isValid;
    }
    /**
     * This method is invoked after soft deleting a record.
     * The default implementation raises the [[EVENT_AFTER_SOFT_DELETE]] event.
     * You may override this method to do postprocessing after the record is deleted.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    public function afterSoftDelete()
    {
        if (method_exists($this->owner, 'afterSoftDelete')) {
            $this->owner->afterSoftDelete();
        }
        $this->owner->trigger(self::EVENT_AFTER_SOFT_DELETE);
    }
    /**
     * @return boolean whether owner "hard" deletion allowed or not.
     */
    protected function isDeleteAllowed()
    {
        if ($this->allowDeleteCallback === null) {
            return false;
        }
        return call_user_func($this->allowDeleteCallback, $this->owner);
    }
    // Restore :
    /**
     * Restores record from "deleted" state, after it has been "soft" deleted.
     * @return integer|false the number of restored rows, or false if the restoration is unsuccessful for some reason.
     */
    public function restore()
    {
        $result = false;
        if ($this->beforeRestore()) {
            $result = $this->restoreInternal();
            $this->afterRestore();
        }
        return $result;
    }
    /**
     * @return integer the number of restored rows.
     * @throws InvalidConfigException on invalid configuration.
     */
    protected function restoreInternal()
    {
        $restoreAttributeValues = $this->restoreAttributeValues;
        if ($restoreAttributeValues === null) {
            foreach ($this->softDeleteAttributeValues as $name => $value) {
                if (is_bool($value) || $value === 1 || $value === 0) {
                    $restoreValue = !$value;
                } elseif (is_int($value)) {
                    if ($value === 1) {
                        $restoreValue = 0;
                    } elseif ($value === 0) {
                        $restoreValue = 1;
                    } else {
                        $restoreValue = $value + 1;
                    }
                } else {
                    throw new InvalidConfigException('Unable to automatically determine restore attribute values, "' . get_class($this) . '::restoreAttributeValues" should be explicitly set.');
                }
                $restoreAttributeValues[$name] = $restoreValue;
            }
        }
        $attributes = [];
        foreach ($restoreAttributeValues as $attribute => $value) {
            if (!is_scalar($value) && is_callable($value)) {
                $value = call_user_func($value, $this->owner);
            }
            $attributes[$attribute] = $value;
        }
        return $this->owner->updateAttributes($attributes);
    }
    /**
     * This method is invoked before record is restored from "deleted" state.
     * The default implementation raises the [[EVENT_BEFORE_RESTORE]] event.
     * @return boolean whether the record should be restored. Defaults to true.
     */
    public function beforeRestore()
    {
        if (method_exists($this->owner, 'beforeRestore')) {
            if (!$this->owner->beforeRestore()) {
                return false;
            }
        }
        $event = new ModelEvent();
        $this->owner->trigger(self::EVENT_BEFORE_RESTORE, $event);
        return $event->isValid;
    }
    /**
     * This method is invoked after record is restored from "deleted" state.
     * The default implementation raises the [[EVENT_AFTER_RESTORE]] event.
     * You may override this method to do postprocessing after the record is restored.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    public function afterRestore()
    {
        if (method_exists($this->owner, 'afterRestore')) {
            $this->owner->afterRestore();
        }
        $this->owner->trigger(self::EVENT_AFTER_RESTORE);
    }
    /**
     * Attempts to perform regular [[BaseActiveRecord::delete()]], if it fails with exception, falls back to [[softDelete()]].
     * If owner database supports transactions, regular deleting attempt will be enclosed in transaction with rollback
     * in case of failure.
     * @return false|integer number of affected rows.
     * @throws \Exception on failure.
     */
    public function safeDelete()
    {
        try {
            $transaction = $this->beginTransaction();
            $result = $this->owner->delete();
            if (isset($transaction)) {
                $transaction->commit();
            }
        } catch (\Exception $exception) {
            if (isset($transaction)) {
                $transaction->rollback();
            }
            $fallbackExceptionClass = $this->deleteFallbackException;
            if ($exception instanceof $fallbackExceptionClass) {
                $result = $this->softDeleteInternal();
            } else {
                throw $exception;
            }
        }
        return $result;
    }
    /**
     * Begins new database transaction if owner allows it.
     * @return \yii\db\Transaction|null transaction instance or `null` if not available.
     */
    private function beginTransaction()
    {
        $db = $this->owner->getDb();
        if ($db->hasMethod('beginTransaction')) {
            return $db->beginTransaction();
        }
        return null;
    }
    // Events :
    /**
     * @inheritdoc
     */
    public function events()
    {
        if ($this->getReplaceRegularDelete()) {
            return [
                BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ];
        } else {
            return [];
        }
    }
    /**
     * Handles owner 'beforeDelete' owner event, applying soft delete and preventing actual deleting.
     * @param ModelEvent $event event instance.
     */
    public function beforeDelete($event)
    {
        if (!$this->isDeleteAllowed()) {
            $this->softDeleteInternal();
            $event->isValid = false;
        }
    }
}