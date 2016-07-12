<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 下午12:03
 */

namespace frontend\controllers;


use common\models\Area;
use yii\web\Controller;

class AreaController extends Controller
{
    public function actionChildren($id)
    {
        \Yii::$app->response->format = 'json';
        if (!is_numeric($id)) {
            $id = null;
        }
        return Area::getChildren($id);
    }
}