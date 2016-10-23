<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/8
 * Time: 下午2:27
 */

namespace common\modules\message\controllers;


use common\modules\message\models\MessageData;
use yii\web\Controller;

class AdminController extends Controller
{
    public function actionIndex()
    {

    }

    public function actionCreate()
    {
        $model = new MessageData();
        $model->group = 'all';
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '发送成功');
            return $this->redirect(['create']);
        }
        return $this->render('create', [
           'model' => $model
        ]);
    }
}