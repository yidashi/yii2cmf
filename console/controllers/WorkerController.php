<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/16
 * Time: 下午9:09
 */

namespace console\controllers;

use udokmeci\yii2beanstalk\BeanstalkController;
use yii\helpers\Console;
use Yii;

class WorkerController extends BeanstalkController
{
    // Those are the default values you can override

    const DELAY_PRIORITY = "1000"; //Default priority
    const DELAY_TIME = 5; //Default delay time

    // Used for Decaying. When DELAY_MAX reached job is deleted or delayed with
    const DELAY_MAX = 3;

    public function listenTubes(){
        return ["tube"];
    }

    /**
     *
     * @param \Pheanstalk\Job $job
     * @return string  self::BURY
     *                 self::RELEASE
     *                 self::DELAY
     *                 self::DELETE
     *                 self::NO_ACTION
     *                 self::DECAY
     *
     */
    public function actionTube($job){
        $sentData = $job->getData();
        try {
            // something useful here
            print_r($sentData);
            return self::DELETE;

            /*if($everthingIsAllRight == true){
                fwrite(STDOUT, Console::ansiFormat("- Everything is allright"."\n", [Console::FG_GREEN]));
                //Delete the job from beanstalkd
                return self::DELETE;
            }

            if($everthingWillBeAllRight == true){
                fwrite(STDOUT, Console::ansiFormat("- Everything will be allright"."\n", [Console::FG_GREEN]));
                //Delay the for later try
                //You may prefer decay to avoid endless loop
                return self::DELAY;
            }

            if($IWantSomethingCustom==true){
                Yii::$app->beanstalk->release($job);
                return self::NO_ACTION;
            }

            fwrite(STDOUT, Console::ansiFormat("- Not everything is allright!!!"."\n", [Console::FG_GREEN]));
            //Decay the job to try DELAY_MAX times.
            return self::DECAY;*/

            // if you return anything else job is burried.
        } catch (\Exception $e) {
            //If there is anything to do.
            fwrite(STDERR, Console::ansiFormat($e."\n", [Console::FG_RED]));
            // you can also bury jobs to examine later
            return self::BURY;
        }
    }
}