<?php

namespace frontend\controllers;

class RewardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        \Yii::$app->session->setFlash('warning', '此功能暂未开放');
        return $this->redirect(\Yii::$app->request->referrer);
    }

}
