<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/11/8
 * Time: 下午10:36
 */

namespace backend\controllers;


use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class CacheController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'flush-cache' => ['post'],
                    'flush-cache-key' => ['post']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFlushCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', '操作成功');
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionFlushCacheKey()
    {
        $key = Yii::$app->request->post('key');
        if (Yii::$app->getCache()->delete($key)) {
            Yii::$app->session->setFlash('success', '操作成功');
        };
        return $this->redirect(['index']);
    }
}