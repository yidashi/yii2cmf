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

class LoadModule extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $models = Yii::$app->cache->get('plugins');
        if ($models === false) {
            $models = Module::find()->where(['status' => 1])->all();
            Yii::$app->cache->set('plugins', $models, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM {{%module}}']));
        }

        foreach ($models as $model) {
            // 加载模块
            $moduleClass = 'modules\\' . $model->name . '\Module';
            if (class_exists($moduleClass)) {
                $app->modules = [$model->name => $moduleClass];
            }
            // 监听事件
            $moduleEventsFile = Yii::getAlias('@modules') . '/' . $model->name . '/config/events.php';
            if (is_file($moduleEventsFile)) {
                $listeners = require $moduleEventsFile;
                $app->events->addListener($listeners);
            }
        }
    }
}