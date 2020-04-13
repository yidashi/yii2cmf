<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:14
 * Description:
 */

namespace common\modules;

use common\components\PackageInfo;
use common\models\Module;
use rbac\models\Menu;
use yii\helpers\ArrayHelper;

class ModuleInfo extends PackageInfo
{
    public $isCore = 0;

    private $_model;

    public function getModuleClass()
    {
        return $this->getNamespace() . '\\' . 'Module';
    }

    /**
     * @return Module
     */
    public function getModel()
    {
        if ($this->_model == null) {
            $models = Module::findAllModules();
            $model = ArrayHelper::getValue($models, $this->getPackage());
            if ($model == null) {
                $model = new Module();
                $model->loadDefaultValues();
                $model->id = $this->getPackage();
            }
            $this->_model = $model;
        }
        return $this->_model;
    }

    /**
     * 在菜单插件管理下添加一个新菜单
     * @param $name
     * @param $route
     * @param int $parent
     * @return bool|Menu
     */
    protected function addMenu($name, $route = null, $parent = 0)
    {
        $model = new Menu();
        $model->name = $name;
        $model->route = $route;
        $model->parent = $parent;
        if ($model->save(false)) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * 删除一个插件管理下的子菜单
     * @param $name
     * @param null $parent
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    protected function deleteMenu($name, $parent = null)
    {
        $menu = Menu::find()->andWhere(['name' => $name])->andFilterWhere(['parent' => $parent])->one();
        if ($menu === null) {
            return true;
        }
        return $menu->delete();
    }
}
