<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58.
 */
namespace frontend\controllers;

use common\models\Comment;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreate()
    {
        $model = new Comment();
        $model->load(\Yii::$app->request->post());
        $model->user_id = \Yii::$app->user->id;
        $returnUrl = \Yii::$app->request->getReferrer();
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', '评论成功！');
        } else {
            \Yii::$app->session->setFlash('error', '评论失败！');
        }

        return $this->redirect($returnUrl);
    }
    // 图文弹幕
    public function actionDm()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $article_id = \Yii::$app->request->post('article_id');
        $time = \Yii::$app->request->post('time');
        $page = \Yii::$app->request->post('page');
        $query = Comment::find()->where(['type' => 'article', 'type_id' => $article_id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->with('user')
            ->asArray()
            ->all();
        $hasNext = 0;
        if ($page < $pages->pageCount) {
            $hasNext = 1;
        }

        return [
            'list' => $models,
            'hasNext' => $hasNext,
            'time' => $time,
        ];
    }
}
