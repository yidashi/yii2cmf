<?php


namespace common\modules\user\traits;

use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
trait AjaxValidationTrait
{
    /**
     * Performs ajax validation.
     *
     * @param Model $model
     *
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post()) && \Yii::$app->request->get('validate', '0') == '1') {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            \Yii::$app->response->data   = ActiveForm::validate($model);
            \Yii::$app->response->send();
            \Yii::$app->end();
        }
    }
}
