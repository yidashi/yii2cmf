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
    public static function getAllJobs()
    {
        return Schedule::find()->all();
    }
}
