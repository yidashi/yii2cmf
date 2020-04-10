<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/4/9
 * Time: 2:10 下午
 */

namespace common\modules\schedule\services;

use common\modules\schedule\models\Schedule;

class ScheduleService
{
    public static function getAllEnableJobs()
    {
        return Schedule::find()->where(['status' => 1])->all();
    }
}
