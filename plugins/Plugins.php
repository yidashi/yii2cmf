<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:28
 */

namespace plugins;


use common\models\Module;
use yii\base\Object;

abstract class Plugins extends Object
{
    public $info = [
        'author' => '',
        'version' => '',
        'name' => '',
        'title' => '',
        'desc' => '',
        'status' => 1
    ];
    final public function checkInfo(){
        $info_check_keys = ['name','title','description','status','author','version'];
        foreach ($info_check_keys as $value) {
            if(!array_key_exists($value, $this->info))
                return false;
        }
        return true;
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

}