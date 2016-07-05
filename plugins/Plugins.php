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

    public function addMenu($name, $route)
    {
        $id = \Yii::$app->db->createCommand('SELECT `id` FROM {{%menu}} WHERE `name`="插件管理"')->queryScalar();
        \Yii::$app->db->createCommand("INSERT INTO {{%menu}}(`name`,`parent`,`route`) VALUES ('{$name}','{$id}','{$route}')")->execute();
        MenuHelper::invalidate();
    }

    public function deleteMenu($name)
    {
        \Yii::$app->db->createCommand("DELETE FROM {{%menu}} WHERE `name`='{$name}'")->execute();
        MenuHelper::invalidate();
    }
    //安装
    public function install()
    {
        if ($this->checkInfo()) {
            $model = new Module();
            $model->attributes = $this->info;
            $model->save();
        }
    }

    //卸载
    public function uninstall()
    {
        $name = $this->info['name'];
        $model = Module::find()->where(['name' => $name])->one();
        $model->delete();
    }

    public function bootstrap($app)
    {
        if ($app->id == 'app-backend' && $this->hasMethod('backend')) {
            $this->backend($app);
        } else if($app->id == 'app-frontend' && $this->hasMethod('frontend')){
            $this->frontend($app);
        }
    }
}