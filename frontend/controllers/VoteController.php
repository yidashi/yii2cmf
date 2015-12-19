<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58
 */

namespace frontend\controllers;


use common\models\Comment;
use common\models\Vote;
use frontend\models\Article;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\AccessControl;

class VoteController extends Controller{
    /**
     * @inheritdoc
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
        $type = \Yii::$app->request->get('type','article');
        $action = \Yii::$app->request->get('action','up');
        $article = Article::find()->where(['id'=>$id])->select('id,up,down')->one();
        $vote = Vote::find()->where(['type_id'=>$id, 'type'=>$type, 'action'=>$action, 'user_id'=>$userId])->one();
        if(empty($vote)){
            $article->$action += 1;
            $article->save(false);
            $vote = new Vote();
            $params = [
                'type'=>$type,
                'action'=>$action,
                'type_id'=>$id,
                'user_id'=>$userId
            ];
            $vote->attributes = $params;
            $vote->save();

        }
        return [
            'up'=> $article->up,
            'down' => $article->down
        ];
    }
}