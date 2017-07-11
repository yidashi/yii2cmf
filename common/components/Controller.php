<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/11/9 9:46
 * Description:
 */

namespace common\components;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class Controller extends \yii\web\Controller
{
    public function renderJson($status = 1, $message = '', $data = [])
    {
        \Yii::$app->response->format = 'json';
        return array_merge(['status' => $status, 'message' => $message], $data);
    }

    public function goReferrer()
    {
        return Yii::$app->controller->redirect(Yii::$app->request->getReferrer());
    }

    public function flash($key, $value)
    {
        Yii::$app->session->setFlash($key, $value);
    }

    public function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax && Yii::$app->request->get('ajax-validate')) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
}