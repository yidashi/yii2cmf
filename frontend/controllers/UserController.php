<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/8
 * Time: 上午11:37
 */

namespace frontend\controllers;


use common\models\Profile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionIndex($id)
    {
        $profile = Profile::find()->where(['id' => $id])->one();
        if (empty($profile)) {
            throw new NotFoundHttpException('用户不存在!');
        }
        return $this->render('index', [
            'profile' => $profile
        ]);
    }

}