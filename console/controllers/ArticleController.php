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

    /**
     * redis保存文章浏览数,定时同步到数据表
     * `crontab -e`
     * `0 2 * * * yii article/sync-view`.
     */
    public function actionSyncView()
    {
        $redis = \Yii::$app->redis;
        $keys = $redis->keys('article:view:*');
        foreach ($keys as $v => $key) {
            $id = implode('', array_slice(explode(':', $key), -1));
            $article = Article::find()->where(['id' => $id])->one();
            if (empty($article)) {
                $redis->del($key);
                continue;
            }
            $view = $redis->get($key);
            // 更新浏览数
            $article->updateCounters(['view' => $view]);
            $redis->del($key);
        }
    }
}
