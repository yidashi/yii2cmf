<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午10:25
 */

namespace common\components;


use common\models\Module;
use common\modules\ModuleInfo;
use yii\helpers\Json;

class ModuleManager extends PackageManager
{
    public $paths = [
        '@common/modules'
    ];

    public $namespace = 'common\\modules\\';

    public $infoClass = 'ModuleInfo';

    public function findCore()
    {
        $all = $this->findAll();
        return array_filter($all, function ($val) {
            if (!$val->isCore) {
                return false;
            }
            return true;
        });
    }

    public function install(ModuleInfo $module)
    {
        $model = $module->getModel();
        $model->attributes = $module->info;
        $model->type = Module::TYPE_CORE;
        $model->config = Json::encode($module->getInitConfig());
        $model->status = Module::STATUS_OPEN;
        if ($model->save()) {
            if (method_exists($module, 'install')) {
                return call_user_func([$module, 'install']);
            }
            return true;
        }
        return false;
    }

    public function uninstall(ModuleInfo $module)
    {
        if ($module->isCore) {
            return false;
        }
        $model = $module->getModel();
        if ($model->delete()) {
            if (method_exists($module, 'uninstall')) {
                call_user_func([$module, 'uninstall']);
            }
            return true;
        }
        return false;
    }
    public function open(ModuleInfo $module)
    {
        $model = $module->getModel();
        $model->status = 1;
        if ($model->save()) {
            if (method_exists($module, 'open')) {
                call_user_func([$module, 'open']);
            }
            return true;
        }
        return false;
    }
    public function close(ModuleInfo $module)
    {
        if ($module->isCore) {
            return false;
        }
        $model = $module->getModel();
        $model->status = 0;
        if ($model->save()) {
            if (method_exists($module, 'close')) {
                call_user_func([$module, 'close']);
            }
            return true;
        }
        return false;
    }

    public function upgrade()
    {

    }
}