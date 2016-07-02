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

class LoadModule extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $models = Module::find()->where(['status' => 1])->all();
        foreach ($models as $model) {
            $moduleClass = 'modules\\' . $model->name . '\Module';
            $app->modules = [$model->name => $moduleClass];
            $moduleEventsFile = Yii::getAlias('@modules') . '/' . $model->name . '/config/events.php';
            if (is_file($moduleEventsFile)) {
                $listeners = require $moduleEventsFile;
                $app->events->addListener($listeners);
            }
        }
    }
}