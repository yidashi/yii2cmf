<?php
namespace gii\controllers;

class DefaultController extends \yii\gii\controllers\DefaultController
{
    
    public function actionIndex()
    {
        $this->layout = '@backend/views/layouts/main.php';
        return $this->render('index');
    }
}
