<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/2
 * Time: 下午6:12
 */

namespace frontend\components;

use common\models\Module;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\caching\DbDependency;

class LoadPlugins extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $models = Yii::$app->cache->get('plugins');
        if ($models === false) {
            $models = Module::find()->where(['status' => 1])->all();
            Yii::$app->cache->set('plugins', $models, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM {{%module}}']));
        }

        foreach ($models as $model) {
            // 模块根路径
            $moduleDir = Yii::getAlias('@plugins') . '/' . $model->name;
            $pluginsClass = 'plugins\\' . $model->name . '\Plugins';
            $plugins = Yii::createObject($pluginsClass);

            if ($plugins instanceof BootstrapInterface) {
                $plugins->bootstrap(Yii::$app);
            }
            // 加载配置
            $envFile = Yii::getAlias('@plugins') . '/' . $model->name . '/.env';
            if (is_file($envFile)) {
                (new \Dotenv\Dotenv($moduleDir))->load();
            }
            // 加载模块
            $moduleClass = 'modules\\' . $model->name . '\Module';
            if (class_exists($moduleClass)) {
                $app->modules = [$model->name => $moduleClass];
            }
        }
    }
}