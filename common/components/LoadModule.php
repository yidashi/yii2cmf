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
use yii\web\Application;
use yii\helpers\ArrayHelper;

class LoadModule extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            // 先判断是否安装，没安装不操作~
            if (!file_exists(Yii::getAlias('@root/web/storage/install.txt'))) {
                return;
            }
        }

        $models = Module::findOpenModules(Module::TYPE_CORE);
        $bootstrapType = $app->id;
        foreach ($models as $model) {
            $this->setModule($model->id, ['class' => $model->class]);
            $bootstraps = explode("|", $model->bootstrap);
            if (in_array($bootstrapType, $bootstraps)) {
                $module = \Yii::$app->getModule($model->id);
                if ($module instanceof BootstrapInterface) {
                    $module->bootstrap($app);
                }
            }
        }
    }

    public function setModule($id, $config)
    {
        $definitions = \Yii::$app->getModules();
        Yii::$app->setModule($id,
            ArrayHelper::merge($config, array_key_exists($id, $definitions) ? $definitions[$id] : [])
        );
    }
}