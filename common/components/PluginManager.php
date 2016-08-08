<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午10:25
 */

namespace common\components;


use plugins\Plugins;

class PluginManager extends PackageManager
{
    public $paths = ['@plugins'];

    public $namespace = 'plugins\\';

    public $infoClass = 'Plugins';

    public function install(Plugins $plugin)
    {
        $plugin->install();
        return true;
    }

    public function uninstall(Plugins $plugin)
    {
        $plugin->uninstall();
        return true;
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

}