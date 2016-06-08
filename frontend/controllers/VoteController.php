<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58.
 */
namespace frontend\controllers;

use common\models\Comment;
use common\models\Vote;
use frontend\models\Article;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\AccessControl;

class VoteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $userId = \Yii::$app->user->id;
        $id = \Yii::$app->request->get('id');
        $type = \Yii::$app->request->get('type', 'article');
        $action = \Yii::$app->request->get('action', 'up');
        $actions = ['up', 'down'];
        array_splice($actions, array_search($action, $actions), 1);
        $oppositeAction = current($actions);
        $model = $this->findModel($id, $type);
        $vote = Vote::find()->where(['type_id' => $id, 'type' => $type, 'user_id' => $userId])->one();
        if (empty($vote)) {
            $model->updateCounters([$action => 1]);
            $vote = new Vote();
            $params = [
                'type' => $type,
                'action' => $action,
                'type_id' => $id,
                'user_id' => $userId,
            ];
            $vote->attributes = $params;
            $vote->save();
        } else {
            // 一篇文章只能持一个态度（顶或者踩,不能同时顶和踩）
            if ($vote->action != $action) {
                $vote->action = $action;
                $vote->save();
                $model->updateCounters([$action => 1, $oppositeAction => -1]);
            }
        }

        return [
            'up' => $model->up,
            'down' => $model->down,
        ];
    }

    private function findModel($id, $type)
    {
        if ($type == 'article') {
            $model = Article::find()->where(['id' => $id])->select('id,up,down')->one();
        } else {
            $model = Comment::find()->where(['id' => $id])->select('id,up,down')->one();
        }
        if (empty($model)) {
            throw new NotFoundHttpException('目标不存在');
        }
        return $model;
    }
}
