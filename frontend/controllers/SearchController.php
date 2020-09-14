<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 下午2:11
 */

namespace frontend\controllers;


use yii\web\Controller;
use yii\web\Cookie;
use Yii;

class SearchController extends Controller
{

    public function actionIndex()
    {
        $q = Yii::$app->request->get('q');
        if (empty($q)){
            return $this->goHome();
        }
        $lastSearchTime = Yii::$app->request->cookies->getValue('lastsearchtime', 0);
        if (time() - $lastSearchTime <= 3) {
            Yii::$app->session->setFlash('error', '搜索太频繁了');
            return $this->goHome();
        }
        $dataProvider = Yii::$app->search->search($q);
        $response = Yii::$app->response;
        $response->cookies->add(new Cookie([
            'name' => 'lastsearchtime',
            'value' => time()
        ]));
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'q' => htmlentities($q, ENT_QUOTES, 'UTF-8')
        ]);
    }
}
