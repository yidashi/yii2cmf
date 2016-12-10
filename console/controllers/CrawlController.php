<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/10/21 17:00
 * Description:
 */

namespace console\controllers;


use common\models\Spider;
use yii\console\Controller;

class CrawlController extends Controller
{
    public function actionIndex($name = 'jianshu')
    {
        $spider = Spider::findOne(['name' => $name]);
        if ($spider == null) {
            die('蜘蛛不存在');
        }
        $spider->crawl();
        \Yii::info('采集' . $spider->title . '成功');
        die('ok');
    }
}