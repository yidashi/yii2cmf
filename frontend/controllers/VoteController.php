<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58.
 */
namespace frontend\controllers;

use common\models\Comment;
use common\models\Vote;
use common\models\VoteInfo;
use frontend\models\Article;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $entity = \Yii::$app->request->get('entity', 'common\models\Article');
        $action = \Yii::$app->request->get('action', 'up');
        $actions = ['up', 'down'];
        array_splice($actions, array_search($action, $actions), 1);
        $oppositeAction = current($actions);
        $vote = Vote::find()->where(['entity_id' => $id, 'entity' => $entity, 'user_id' => $userId])->one();
        if (empty($vote)) {
            $vote = new Vote();
            $params = [
                'entity' => $entity,
                'action' => $action,
                'entity_id' => $id,
                'user_id' => $userId,
            ];
            $vote->attributes = $params;
            $vote->save();
            VoteInfo::updateAllCounters([$action => 1], ['entity' => $entity, 'entity_id' => $id]);
        } else {
            // 一篇文章只能持一个态度（顶或者踩,不能同时顶和踩）
            if ($vote->action != $action) {
                $vote->action = $action;
                $vote->save();
                VoteInfo::updateAllCounters([$action => 1, $oppositeAction => -1], ['entity' => $entity, 'entity_id' => $id]);
            }
        }

        return [
            'up' => (int)VoteInfo::find()->where(['entity' => $entity, 'entity_id' => $id])->select('up')->scalar(),
            'down' => (int)VoteInfo::find()->where(['entity' => $entity, 'entity_id' => $id])->select('down')->scalar(),
        ];
    }
}
