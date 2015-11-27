<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54
 */

namespace frontend\controllers;


use common\models\Article;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller{
    public function actionList()
    {
        $query = Article::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('list', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionView($id)
    {
        $content = Article::find()->where(['id'=>$id])->asArray()->one();
        if(empty($content)){
            throw new NotFoundHttpException('not found');
        }
        return $this->render('view', $content);
    }
} 