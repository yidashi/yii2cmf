<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54.
 */
namespace frontend\controllers;

use common\models\Comment;
use frontend\models\Article;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionIndex($cate)
    {
        $category = Category::find()->where(['name' => $cate])->one();
        if (empty($category)) {
            throw new NotFoundHttpException();
        }
        $query = Article::find()->where(['status' => Article::STATUS_ACTIVE])->andFilterWhere(['category_id' => $category->id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->select('id,title,cover,view,up,down,created_at,user_id,desc')
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category,
        ]);
    }
    public function actionView($id)
    {
        $model = Article::find()->where(['id' => $id, 'status' => Article::STATUS_ACTIVE])->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        // 浏览量变化
        $model->addView();
        $commentModel = new Comment();
        $commentQuery = Comment::find()->where(['article_id' => $id, 'parent_id' => 0]);
        $countCommentQuery = clone $commentQuery;
        $pages = new Pagination(['totalCount' => $countCommentQuery->count()]);
        $commentModels = $commentQuery->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();
        $hots = Article::find()
            ->where(['category_id' => $model->category_id])
            ->limit(10)
            ->orderBy('view desc')
            ->all();

        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'commentModels' => $commentModels,
            'pages' => $pages,
            'hots' => $hots,
        ]);
    }
}
