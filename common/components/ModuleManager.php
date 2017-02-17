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

    public function install(ModuleInfo $module)
    {
        $model = $module->getModel();
        $model->attributes = $module->info;
        $model->type = Module::TYPE_CORE;
        $model->config = Json::encode($module->getInitConfig());
        $model->status = Module::STATUS_OPEN;
        return $model->save();
    }

    public function uninstall(ModuleInfo $module)
    {
        $model = $module->getModel();
        return $model->delete();
    }
    public function open(ModuleInfo $module)
    {
        $model = $module->getModel();
        $model->status = 1;
        return $model->save();
    }
    public function close(ModuleInfo $module)
    {
        $model = $module->getModel();
        $model->status = 0;
        return $model->save();
    }

    public function upgrade()
    {

    }
}