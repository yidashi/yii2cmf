<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/30
 * Time: 下午2:11
 */

namespace frontend\controllers;


use common\models\Article;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SearchController extends Controller
{
    /**
     * 简单先来一个搜索,搜索太大太深
     * @param $word string
     * @return string
     */
    public function actionIndex($q)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->published()->andWhere(['like', 'title', $q])
        ]);
        return $this->render('index', [
           'dataProvider' => $dataProvider,
            'q' => $q
        ]);
    }
}