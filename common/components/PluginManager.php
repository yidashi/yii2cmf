<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午10:25
 */

namespace common\components;


use common\models\Module;
use plugins\Plugin;
use yii\helpers\Json;

class PluginManager extends PackageManager
{
    public $paths = ['@plugins'];

    public $namespace = 'plugins\\';

    public $infoClass = 'Plugin';

    public function install(Plugin $plugin)
    {
        try {
            if ($plugin->install()) {
                $model = $plugin->getModel();
                $model->attributes = $plugin->info;
                $model->config = Json::encode($plugin->getInitConfig());
                $model->status = Module::STATUS_OPEN;
                return $model->save();
            }
            return false;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function uninstall(Plugin $plugin)
    {
        try {
            if ($plugin->uninstall()) {
                $model = $plugin->getModel();
                return $model->delete();
            }
            return false;
        } catch(\Exception $e) {
            return false;
        }
    }
    public function open(Plugin $plugin)
    {
        $model = $plugin->getModel();
        $model->status = 1;
        return $model->save();
    }
    public function close(Plugin $plugin)
    {
        $model = $plugin->getModel();
        $model->status = 0;
        return $model->save();
    }

    public function upgrade()
    {

    }
}