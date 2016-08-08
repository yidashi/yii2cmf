<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/2
 * Time: 下午6:12
 */

namespace common\components;

use common\models\Module;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\caching\DbDependency;
use plugins\Plugins;

class LoadModule extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $models = Module::findOpenModules(Module::TYPE_CORE);
        $bootstrapType = $app->id;
        foreach ($models as $model) {
            Yii::$app->setModule($model->id, [
                'class' => $model->class
            ]);
            $bootstraps = explode("|", $model->bootstrap);
            if (in_array($bootstrapType, $bootstraps)) {
                $module = \Yii::$app->getModule($model->id);
                if ($module instanceof BootstrapInterface) {
                    $module->bootstrap($app);
                }
            }
        }
    }
}