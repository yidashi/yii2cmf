<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/10
 * Time: 下午7:05
 */

namespace common\components;


use yii\helpers\ArrayHelper;

class WebController extends \yii\web\Controller
{
    public function renderJson($status, $message, $data = [])
    {
        \Yii::$app->response->format = 'json';
        return ArrayHelper::merge([
            'status' => $status,
            'message' => $message,
        ], $data);
    }
}