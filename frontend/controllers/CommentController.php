<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58
 */

namespace frontend\controllers;


use common\models\Comment;
use yii\web\Controller;

class CommentController extends Controller{
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
} 