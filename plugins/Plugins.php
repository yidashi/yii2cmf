<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:28
 */

namespace plugins;


use common\models\Module;
use yii\base\BootstrapInterface;
use yii\base\Object;
use mdm\admin\components\MenuHelper;

abstract class Plugins extends Object implements BootstrapInterface
{
    public $info = [
        'author' => '',
        'version' => '',
        'name' => '',
        'title' => '',
        'desc' => ''
    ];
    final public function checkInfo(){
        $info_check_keys = ['name','title','desc','author','version'];
        foreach ($info_check_keys as $value) {
            if(!array_key_exists($value, $this->info))
                return false;
        }
        return true;
    }

    /**
     * 在菜单插件管理下添加一个新菜单
     * @param $name
     * @param $route
     * @throws \yii\db\Exception
     */
    public function addMenu($name, $route)
    {
        $id = \Yii::$app->db->createCommand('SELECT `id` FROM {{%menu}} WHERE `name`="插件管理"')->queryScalar();
        \Yii::$app->db->createCommand("INSERT INTO {{%menu}}(`name`,`parent`,`route`) VALUES ('{$name}','{$id}','{$route}')")->execute();
        MenuHelper::invalidate();
    }

    /**
     * 删除一个插件管理下的子菜单
     * @param $name
     * @throws \yii\db\Exception
     */
    public function deleteMenu($name)
    {
        \Yii::$app->db->createCommand("DELETE FROM {{%menu}} WHERE `name`='{$name}'")->execute();
        MenuHelper::invalidate();
    }

    /**
     * 安装插件时候执行
     * 比如后台添加菜单,建表等
     */
    public function install()
    {
        if ($this->checkInfo()) {
            $model = Module::find()->where(['name' => $this->info['name']])->one();
            if (empty($model)) {
                $model = new Module();
                $model->attributes = $this->info;
            } else {
                $model->status = Module::STATUS_OPEN;
            }
            $model->save();
        }
    }

    //卸载
    public function uninstall()
    {
        $name = $this->info['name'];
        $model = Module::find()->where(['name' => $name])->one();
        $model->status = Module::STATUS_UNINSTALL;
        $model->save();
    }

    /**
     * 各插件在系统bootstrap阶段执行,前台执行frontend方法,后台执行backend方法.
     * 比如插件要在后台添加一个控制器,则可以这样写
     * ```
        public function backend($app)
        {
            $app->controllerMap['donation'] = [
                'class' => '\plugins\donation\controllers\AdminController',
                'viewPath' => '@plugins/donation/views/admin'
            ];
        }
     * ```
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if ($app->id == 'app-backend' && $this->hasMethod('backend')) {
            $this->backend($app);
        } else if($app->id == 'app-frontend' && $this->hasMethod('frontend')){
            $this->frontend($app);
        }
    }
}