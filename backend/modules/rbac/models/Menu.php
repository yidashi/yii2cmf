<?php

namespace rbac\models;

use common\behaviors\CacheInvalidateBehavior;
use common\behaviors\PositionBehavior;
use rbac\components\Configs;
use rbac\components\MenuHelper;
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
            [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'order',
                'groupAttributes' => [
                    'parent' // multiple lists varying by 'parent'
                ],
            ],
            [
                'class' => CacheInvalidateBehavior::className(),
                'tags' => [
                    MenuHelper::CACHE_TAG
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'unique', 'targetAttribute' => ['name', 'parent']],
            [['parent'], 'in', 'range' => static::find()->select(['id'])->column(), 'message' => 'Menu "{value}" not found.', ],
            [['data', 'parent'], 'default'],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac', 'ID'),
            'name' => Yii::t('rbac', 'Name'),
            'parent' => Yii::t('rbac', 'Parent'),
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

    public static function getDropDownList($tree = [], &$result = [], $deep = 0, $separator = '&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        $deep++;
        foreach($tree as $list) {
            $result[$list['id']] = str_repeat($separator, $deep-1) . $list['name'];
            if (isset($list['children'])) {
                self::getDropDownList($list['children'], $result, $deep);
            }
        }
        return $result;
    }
}
