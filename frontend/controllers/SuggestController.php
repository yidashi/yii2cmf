<?php
/**
 * author: yidashi
 * Date: 2015/12/21
 * Time: 11:37.
 */
namespace frontend\controllers;

use yii\web\Controller;

class SuggestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
