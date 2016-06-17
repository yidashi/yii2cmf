<?php

namespace console\controllers;

use common\models\Article;
use console\models\SpiderFactory;
use yii\console\Controller;

class ArticleController extends Controller
{
    /*
    * ps aux|grep yii      查看是否在后台运行  php yii queue/run
    *如果没有后台运行
    * QUEUE=* php yii queue/run &
     *
     * 采集文章的时候
     * php yii article/run php100
    * */
    public function actionRun($name = null)
    {
        $spider = SpiderFactory::create($name);
        $spider->process();
    }
}
