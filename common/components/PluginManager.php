<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午10:25
 */

namespace common\components;


use common\models\Module;
use plugins\Plugins;
use yii\helpers\Json;

class PluginManager extends PackageManager
{
    public $paths = ['@plugins'];

    public $namespace = 'plugins\\';

    public $infoClass = 'Plugins';

    public function install(Plugins $plugin)
    {
        $model = $plugin->getModel();
        $model->attributes = $plugin->info;
        $model->type = Module::TYPE_PLUGIN;
        $model->config = Json::encode($plugin->getInitConfig());
        $model->status = Module::STATUS_OPEN;
        return $model->save();
    }

    public function uninstall(Plugins $plugin)
    {
        $model = $plugin->getModel();
        return $model->delete();
    }
    public function open(Plugins $plugin)
    {
        $model = $plugin->getModel();
        $model->status = 1;
        return $model->save();
    }
    public function close(Plugins $plugin)
    {
        $model = $plugin->getModel();
        $model->status = 0;
        return $model->save();
    }

    public function upgrade()
    {

    }
}