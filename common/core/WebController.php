<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/10
 * Time: 下午7:05
 */

namespace common\core;


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

    public function setFlash($key, $value = true, $removeAfterAccess = true)
    {
        \Yii::$app->session->setFlash($key, $value, $removeAfterAccess);
    }
}