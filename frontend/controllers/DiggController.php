<?php
/**
 * author: yidashi
 * Date: 2015/12/11
 * Time: 16:58
 */

namespace frontend\controllers;


use common\models\Comment;
use frontend\models\Article;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\AccessControl;

class DiggController extends Controller{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['up', 'down'],
                'rules' => [
                    [
                        'actions' => ['up', 'down'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionUp()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'up'=> 1,
            'down' => 2
        ];
    }
    public function actionDown()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'up'=> 1,
            'down' => 2
        ];
    }
} 