<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;

/**
 * PositionBehavior allows managing custom order for the records in the database.
 * Behavior uses the specific integer field of the database entity to set up position index.
 * Due to this the database entity, which the model refers to, must contain field [[positionAttribute]].
 *
 * ```php
 * class Item extends ActiveRecord
 * {
 *     public function behaviors()
 *     {
 *         return [
 *             'positionBehavior' => [
 *                 'class' => PositionBehavior::className(),
 *                 'positionAttribute' => 'position',
 *             ],
 *         ];
 *     }
 * }
 * ```
 *
 * @property BaseActiveRecord $owner owner ActiveRecord instance.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class PositionBehavior extends Behavior
{
    /**
     * @var string name owner attribute, which will store position value.
     * This attribute should be an integer.
     */
    public $positionAttribute = 'position';
    /**
     * @var array list of owner attribute names, which values split records into the groups,
     * which should have their own positioning.
     * Example: `['group_id', 'category_id']`
     */
    public $groupAttributes = [];

    /**
     * @var integer position value, which should be applied to the model on its save.
     * Internal usage only.
     */
    private $positionOnSave;


    /**
     * Moves owner record by one position towards the start of the list.
     * @return boolean movement successful.
     */
    public function movePrev()
    {
        $positionAttribute = $this->positionAttribute;

        /* @var $previousRecord BaseActiveRecord */
        $previousRecord = $this->owner->find()
            ->andWhere($this->createGroupConditionAttributes())
            ->andWhere([$positionAttribute => ($this->owner->$positionAttribute - 1)])
            ->one();

        if (empty($previousRecord)) {
            return false;
        }

        $previousRecord->updateAttributes([
            $positionAttribute => $this->owner->$positionAttribute
        ]);

        $this->owner->updateAttributes([
            $positionAttribute => $this->owner->$positionAttribute - 1
        ]);

        return true;
    }

    /**
     * Moves owner record by one position towards the end of the list.
     * @return boolean movement successful.
     */
    public function moveNext()
    {
        $positionAttribute = $this->positionAttribute;

        /* @var $nextRecord BaseActiveRecord */
        $nextRecord = $this->owner->find()
            ->andWhere($this->createGroupConditionAttributes())
            ->andWhere([$positionAttribute => ($this->owner->$positionAttribute + 1)])
            ->one();

        if (empty($nextRecord)) {
            return false;
        }

        $nextRecord->updateAttributes([
            $positionAttribute => $this->owner->$positionAttribute
        ]);

        $this->owner->updateAttributes([
            $positionAttribute => $this->owner->getAttribute($positionAttribute) + 1
        ]);

        return true;
    }

    /**
     * Moves owner record to the start of the list.
     * @return boolean movement successful.
     */
    public function moveFirst()
    {
        $positionAttribute = $this->positionAttribute;
        if ($this->owner->$positionAttribute == 1) {
            return false;
        }

        $this->owner->updateAllCounters(
            [
                $positionAttribute => +1
            ],
            [
                'and',
                $this->createGroupConditionAttributes(),
                ['<', $positionAttribute, $this->owner->$positionAttribute]
            ]
        );

        $this->owner->updateAttributes([
            $positionAttribute => 1
        ]);

        return true;
    }

    /**
     * Moves owner record to the end of the list.
     * @return boolean movement successful.
     */
    public function moveLast()
    {
        $positionAttribute = $this->positionAttribute;

        $recordsCount = $this->countGroupRecords();
        if ($this->owner->getAttribute($positionAttribute) == $recordsCount) {
            return false;
        }

        $this->owner->updateAllCounters(
            [
                $positionAttribute => -1
            ],
            [
                'and',
                $this->createGroupConditionAttributes(),
                ['>', $positionAttribute, $this->owner->$positionAttribute]
            ]
        );

        $this->owner->updateAttributes([
            $positionAttribute => $recordsCount
        ]);

        return true;
    }

    /**
     * Moves owner record to the specific position.
     * If specified position exceeds the total number of records,
     * owner will be moved to the end of the list.
     * @param integer $position number of the new position.
     * @return boolean movement successful.
     */
    public function moveToPosition($position)
    {
        if (!is_numeric($position) || $position < 1) {
            return false;
        }
        $positionAttribute = $this->positionAttribute;

        $oldRecord = $this->owner->findOne($this->owner->getPrimaryKey());

        $oldRecordPosition = $oldRecord->$positionAttribute;

        if ($oldRecordPosition == $position) {
            return true;
        }

        if ($position < $oldRecordPosition) {
            // Move Up:
            $this->owner->updateAllCounters(
                [
                    $positionAttribute => +1
                ],
                [
                    'and',
                    $this->createGroupConditionAttributes(),
                    ['>=', $positionAttribute, $position],
                    ['<', $positionAttribute, $oldRecord->$positionAttribute],
                ]
            );

            $this->owner->updateAttributes([
                $positionAttribute => $position
            ]);

            return true;
        } else {
            // Move Down:
            $recordsCount = $this->countGroupRecords();
            if ($position >= $recordsCount) {
                return $this->moveLast();
            }

            $this->owner->updateAllCounters(
                [
                    $positionAttribute => -1
                ],
                [
                    'and',
                    $this->createGroupConditionAttributes(),
                    ['>', $positionAttribute, $oldRecord->$positionAttribute],
                    ['<=', $positionAttribute, $position],
                ]
            );

            $this->owner->updateAttributes([
                $positionAttribute => $position
            ]);

            return true;
        }
    }

    /**
     * Creates array of group attributes with their values.
     * @see groupAttributes
     * @return array attribute conditions.
     */
    protected function createGroupConditionAttributes()
    {
        $condition = [];
        if (!empty($this->groupAttributes)) {
            foreach ($this->groupAttributes as $attribute) {
                $condition[$attribute] = $this->owner->$attribute;
            }
        }
        return $condition;
    }

    /**
     * Finds the number of records which belongs to the group of the owner.
     * @see groupAttributes
     * @return integer records count.
     */
    protected function countGroupRecords()
    {
        $query = $this->owner->find();
        if (!empty($this->groupAttributes)) {
            $query->andWhere($this->createGroupConditionAttributes());
        }
        return $query->count();
    }

    // Events :

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Handles owner 'beforeInsert' owner event, preparing its positioning.
     * @param ModelEvent $event event instance.
     */
    public function beforeInsert($event)
    {
        $positionAttribute = $this->positionAttribute;
        if ($this->owner->$positionAttribute > 0) {
            $this->positionOnSave = $this->owner->$positionAttribute;
        }
        $this->owner->$positionAttribute = $this->countGroupRecords() + 1;
    }

    /**
     * Handles owner 'beforeInsert' owner event, preparing its possible re-positioning.
     * @param ModelEvent $event event instance.
     */
    public function beforeUpdate($event)
    {
        $positionAttribute = $this->positionAttribute;

        $isNewGroup = false;
        foreach ($this->groupAttributes as $groupAttribute) {
            if ($this->owner->isAttributeChanged($groupAttribute, false)) {
                $isNewGroup = true;
                break;
            }
        }

        if ($isNewGroup) {
            $oldRecord = $this->owner->findOne($this->owner->getPrimaryKey());
            $oldRecord->moveLast();
            $this->positionOnSave = $this->owner->$positionAttribute;
            $this->owner->$positionAttribute = $this->countGroupRecords() + 1;
        } else {
            if ($this->owner->isAttributeChanged($positionAttribute, false)) {
                $this->positionOnSave = $this->owner->$positionAttribute;
                $this->owner->$positionAttribute = $this->owner->getOldAttribute($positionAttribute);
            }
        }
    }

    /**
     * This event raises after owner inserted or updated.
     * It applies previously set [[positionOnSave]].
     * This event supports other functionality.
     * @param ModelEvent $event event instance.
     */
    public function afterSave($event)
    {
        if ($this->positionOnSave !== null) {
            $this->moveToPosition($this->positionOnSave);
        }
        $this->positionOnSave = null;
    }

    /**
     * Handles owner 'beforeDelete' owner event, moving it to the end of the list before deleting.
     * @param ModelEvent $event event instance.
     */
    public function beforeDelete($event)
    {
        $this->moveLast();
    }
}