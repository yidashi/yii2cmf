<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58.
 */
namespace common\modules\comment\frontend\controllers;

use common\modules\comment\models\Comment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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
        Yii::$app->response->format = 'json';
        $model = new Comment();
        $model->load(Yii::$app->request->post());
        if ($model->save()) {
            return ['message' => '评论成功'];
        } else {
            return ['status' => 0, 'message' => '评论失败'];
        }
    }
}
