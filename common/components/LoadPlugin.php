<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/2
 * Time: 下午6:12
 */
namespace common\components;

use common\models\Plugin as PluginModel;
use plugins\Plugin;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;

class LoadPlugin extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // 先判断是否安装，没安装不操作~
        if (!file_exists(Yii::getAlias('@root/web/storage/install.txt'))) {
            return;
        }

        $models = PluginModel::findOpenPlugins();
        foreach ($models as $model) {
            /* @var $plugins Plugin*/
            $plugins = Yii::$app->pluginManager->findOne($model->id);
            if ($plugins instanceof BootstrapInterface) {
                $plugins->bootstrap($app);
            }
            // 设置别名
            if (!empty($plugins->aliases)) {
                foreach ($plugins->aliases as $name => $path) {
                    Yii::setAlias($name, $path);
                }
            }
            // 如果插件里有模块，加载模块
            /*$moduleClass = $plugins->getNamespace() . '\Module';
            if (class_exists($moduleClass) && $plugins->app == $app->id) {
                $app->setModule($model->id, $moduleClass);
            }*/
        }
    }
}