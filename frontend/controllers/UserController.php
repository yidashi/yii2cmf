<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 上午11:37
 */

namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionIndex($id)
    {
        $user = User::find()->where(['id' => $id])->one();
        if (empty($user)) {
            throw new NotFoundHttpException('用户不存在!');
        }
        return $this->render('index', [
            'user' => $user
        ]);
    }

}