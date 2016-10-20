<?php

namespace rbac\models;

use rbac\components\DbManager;
use rbac\validators\RbacValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class Assignment extends Model
{

    /** @var array */
    public $items = [];

    /** @var integer */
    public $user_id;

    /** @var boolean */
    public $updated = false;

    /** @var DbManager */
    protected $manager;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->manager = Yii::$app->authManager;
        if ($this->user_id === null) {
            throw new InvalidConfigException('user_id must be set');
        }

        $this->items = array_keys($this->manager->getItemsByUser($this->user_id));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'items' => '角色'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'user_id',
                'required'
            ],
            [
                'items',
                RbacValidator::className()
            ],
            [
                'user_id',
                'integer'
            ]
        ];
    }

    /**
     * Updates auth assignments for user.
     *
     * @return boolean
     */
    public function updateAssignments()
    {
        if (! $this->validate()) {
            return false;
        }

        if (! is_array($this->items)) {
            $this->items = [];
        }

        $assignedItems = $this->manager->getItemsByUser($this->user_id);
        $assignedItemsNames = array_keys($assignedItems);

        foreach (array_diff($assignedItemsNames, $this->items) as $item) {
            $this->manager->revoke($assignedItems[$item], $this->user_id);
        }

        foreach (array_diff($this->items, $assignedItemsNames) as $item) {
            $this->manager->assign($this->manager->getItem($item), $this->user_id);
        }

        $this->updated = true;

        return true;
    }

    /**
     * Returns all available auth items to be attached to user.
     *
     * @return array
     */
    public function getAvailableItems($type)
    {
        if ($type == Item::TYPE_ROLE) {
            $items = $this->manager->getRoles();
        } else {
            $items = $this->manager->getPermissions();
        }

        return ArrayHelper::map($items, 'name', function ($item) {
            return empty($item->description) ? $item->name : $item->name . ' (' . $item->description . ')';
        });
    }

    public function getAvailableRoles()
    {
        return $this->getAvailableItems(Item::TYPE_ROLE);
    }

}