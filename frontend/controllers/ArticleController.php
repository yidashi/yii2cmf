<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54
 */

namespace frontend\controllers;


use common\models\Article;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller{
    public function actionIndex($cid=0)
    {
        $category = Category::find()->where(['id'=>$cid])->select('title')->scalar();
        $query = Article::find()->andFilterWhere(['category_id'=>$cid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category
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