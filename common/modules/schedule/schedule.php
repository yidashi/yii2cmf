<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/16
 * Time: 下午9:57
 */

/**
 * 任务调度
 * crontab -e * * * * * php /path/to/yii schedule/run  1>> /dev/null 2>&1
 * @see
 * @var \omnilight\scheduling\Schedule $schedule
 */

// $schedule->command('migrate')->cron('* * * * *');

// $schedule->exec('composer self-update')->daily();

$jobs = \common\modules\schedule\services\ScheduleService::getAllJobs();

foreach ($jobs as $job) {
    $schedule->command($job->job)->cron($job->cron);
}