<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2020/4/8 12:04
 * Description:
 */

namespace common\modules\schedule;

use yii\base\BootstrapInterface;

class Module extends \common\modules\Module implements BootstrapInterface
{
    /**
     * 这个没生效 TODO
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        if ($app->id == 'console') {
            $app->controllerMap['schedule'] = [
                'class' => \omnilight\scheduling\ScheduleController::className(),
                'scheduleFile' => __DIR__ . '/schedule.php'
            ];
        }
    }
}