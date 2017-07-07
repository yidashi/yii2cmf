<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 下午12:03
 */

namespace common\modules\city\controllers;


use common\models\City;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionChildren($id)
    {
        \Yii::$app->response->format = 'json';
        if (!is_numeric($id)) {
            $id = null;
        }
        return City::getChildren($id);
    }
}