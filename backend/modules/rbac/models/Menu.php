<?php

namespace rbac\models;

use common\behaviors\PositionBehavior;
use rbac\components\Configs;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "menu".
 *
 * @property int $id Menu id(autoincrement)
 * @property string $name Menu name
 * @property int $parent Menu parent
 * @property string $route Route for this menu
 * @property int $order Menu order
 * @property string $data Extra information for this menu
 * @property Menu $menuParent Menu parent
 * @property Menu[] $menus Menu children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class Menu extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Configs::instance()->menuTable;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDb()
    {
        if (Configs::instance()->db !== null) {
            return Configs::instance()->db;
        } else {
            return parent::getDb();
        }
    }
    public function behaviors()
    {
        return [
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'order',
                'groupAttributes' => [
                    'parent' // multiple lists varying by 'parent'
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique'],
            [['parent_name'], 'filterParent'],
            [['parent_name'], 'in',
                'range' => static::find()->select(['name'])->column(),
                'message' => 'Menu "{value}" not found.', ],
            [['parent', 'route', 'data', 'order'], 'default'],
            ['route', function($attribute){
                if (!empty($this->$attribute)) {
                    $this->addError('route', '一级菜单不能有地址');
                    return false;
                }
                return true;
            }, 'when' => function($model){
                return is_null($model->parent);
            }],
            ['icon', 'string'],
            [['order'], 'integer'],
            [['route'], 'in',
                'range' => static::getSavedRoutes(),
                'message' => 'Route "{value}" not found.', ],
        ];
    }

    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $value = $this->parent_name;
        $parent = self::findOne(['name' => $value]);
        if ($parent) {
            $id = $this->id;
            $parent_id = $parent->id;
            while ($parent) {
                if ($parent->id == $id) {
                    $this->addError('parent_name', 'Loop detected.');

                    return;
                }
                $parent = $parent->menuParent;
            }
            $this->parent = $parent_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac', 'ID'),
            'name' => Yii::t('rbac', 'Name'),
            'parent' => Yii::t('rbac', 'Parent'),
            'parent_name' => Yii::t('rbac', 'Parent Name'),
            'route' => Yii::t('rbac', 'Route'),
            'icon' => Yii::t('rbac', 'Icon'),
            'order' => Yii::t('rbac', 'Order'),
            'data' => Yii::t('rbac', 'Data'),
        ];
    }

    /**
     * Get menu parent.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent']);
    }

    /**
     * Get menu children.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(self::className(), ['parent' => 'id']);
    }

    /**
     * Get saved routes.
     *
     * @return array
     */
    public static function getSavedRoutes()
    {
        $result = [];
        foreach (Yii::$app->getAuthManager()->getPermissions() as $name => $value) {
            if ($name[0] === '/' && substr($name, -1) != '*') {
                $result[] = $name;
            }
        }

        return $result;
    }
}
