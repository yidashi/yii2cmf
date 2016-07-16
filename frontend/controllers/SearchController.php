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
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class SearchController extends Controller
{
    /**
     * 简单先来一个搜索,搜索太大太深
     * @param $q string 关键词
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionIndex($q)
    {
        if (empty($q)) {
            throw new BadRequestHttpException('搜索关键词不能为空');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->published()->andWhere(['like', 'title', $q])
        ]);
        return $this->render('index', [
           'dataProvider' => $dataProvider,
            'q' => $q
        ]);
    }
}