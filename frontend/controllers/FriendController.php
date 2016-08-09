<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/9
 * Time: 上午9:12
 */

namespace frontend\controllers;


use common\models\Friend;
use yii\base\Exception;
use yii\web\Controller;

class FriendController extends Controller
{
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