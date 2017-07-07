<?php
namespace migration;

use yii\base\BootstrapInterface;

class Module extends \common\modules\Module implements BootstrapInterface
{
    public $migrationPath = "@database/migrations";

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap['migrate'] = [
                'class' => 'migration\console\MigrateController',
                'module' => $this,
            ];
        }
    }
}
