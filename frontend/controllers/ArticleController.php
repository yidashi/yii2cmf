<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 11:54
 */

namespace frontend\controllers;


use common\models\Comment;
use frontend\models\Article;
use common\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller{
    public function actionIndex($cid=0)
    {
        $category = Category::find()->where(['id'=>$cid])->select('title')->scalar();
        $query = Article::find()->where(['status'=>Article::STATUS_ACTIVE])->andFilterWhere(['category_id'=>$cid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();
        foreach ($models as &$model) {
            if(\Yii::$app->redis->get('article:view:' . $model->id) == 0){
                if($model->created_at < time() - 60*60*3) {
                    \Yii::$app->redis->set('article:view:' . $model->id, mt_rand(50,888));
                }else {
                    \Yii::$app->redis->set('article:view:' . $model->id, 0);
                }
            }
            $model->view = \Yii::$app->redis->get('article:view:' . $model->id);
        }
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category
        ]);
    }
    public function actionView($id)
    {
        $model = Article::find()->where(['id'=>$id,'status'=>Article::STATUS_ACTIVE])->one();
        if($model === null){
            throw new NotFoundHttpException('not found');
        }
        $redis = \Yii::$app->redis;
        $rkey = 'article:view:' . $id;
        if($redis->exists($rkey)) {
            $redis->incr($rkey);
        }else{
            if($model->view == 0 && $model->created_at < time() - 60*60*3) {
                $redis->set($rkey, mt_rand(50,888));
            }else {
                $redis->set($rkey, $model->view);
            }
        }
        $model->view = $redis->get('article:view:' . $id);
        $commentModel = new Comment();
        $commentQuery = Comment::find()->where(['article_id'=>$id, 'parent_id'=>0]);
        $countCommentQuery = clone $commentQuery;
        $pages = new Pagination(['totalCount' => $countCommentQuery->count()]);
        $commentModels = $commentQuery->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->all();
        $hots = Article::find()
            ->where(['category_id'=>$model->category_id])
            ->limit(10)
            ->orderBy('view desc')
            ->all();
        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'commentModels' => $commentModels,
            'pages' => $pages,
            'hots' => $hots
        ]);
    }
} 