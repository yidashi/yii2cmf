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
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionIndex($cate)
    {
        $category = Category::find()->andWhere(['name' => $cate])->one();
        if (empty($category)) {
            throw new NotFoundHttpException();
        }
        $query = Article::find()->active()->andFilterWhere(['category_id' => $category->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        $pages = $dataProvider->getPagination();
        $models = $dataProvider->getModels();
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category,
        ]);
    }

    /**
     * 文章详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::find()->where(['id' => $id])->active()->one();
        if ($model === null) {
            throw new NotFoundHttpException('not found');
        }
        // 浏览量变化
        $model->addView();
        // sidebar
        $hots = Article::hots($model->category_id);
        // 评论列表
        $commentDataProvider = new ActiveDataProvider([
            'query' => Comment::find()->andWhere(['article_id' => $id, 'parent_id' => 0]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        $commentModels = $commentDataProvider->getModels();
        $pages = $commentDataProvider->getPagination();
        // 评论框
        $commentModel = new Comment();
        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'commentModels' => $commentModels,
            'pages' => $pages,
            'hots' => $hots,
            'commentDataProvider' => $commentDataProvider
        ]);
    }
}
