<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/9
 * Time: 上午9:12
 */

namespace frontend\controllers;


use common\models\Friend;
use yii\filters\AccessControl;
use yii\web\Controller;

class FriendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionFollow($id)
    {
        \Yii::$app->response->format = 'json';
        $model = new Friend();
        if ($model->isFollow($id)) {
            $model->cancelFollow($id);
            return [
                'message' => '已取消'
            ];
        } else {
            $model->follow($id);
            return [
                'message' => '已关注'
            ];
        }
    }
}