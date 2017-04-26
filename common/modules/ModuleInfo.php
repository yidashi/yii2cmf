<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:14
 * Description:
 */

namespace common\modules;


use common\components\PackageInfo;
use rbac\models\Menu;

class ModuleInfo extends PackageInfo
{
    public $isCore = 0;
    public function getModuleClass()
    {
        return $this->getNamespace() . '\\' . 'Module';
    }

    /**
     * 在菜单插件管理下添加一个新菜单
     * @param $name
     * @param $route
     * @throws \yii\db\Exception
     * @return bool
     */
    protected function addMenu($name, $route)
    {
        $id = \Yii::$app->db->createCommand('SELECT `id` FROM {{%menu}} WHERE `name`="插件" AND `parent` IS NULL')->queryScalar();
        $model = new Menu();
        $model->name = $name;
        $model->route = $route;
        $model->parent = $id;
        return $model->save(false);
    }

    /**
     * 删除一个插件管理下的子菜单
     * @param $name
     * @throws \yii\db\Exception
     * @return bool
     */
    protected function deleteMenu($name)
    {
        $id = \Yii::$app->db->createCommand('SELECT `id` FROM {{%menu}} WHERE `name`="插件" AND `parent` IS NULL')->queryScalar();
        $menu = Menu::find()->where(['parent' => $id])->andWhere(['name' => $name])->one();
        if ($menu === null) {
            return true;
        }
        return $menu->delete();
    }
}
