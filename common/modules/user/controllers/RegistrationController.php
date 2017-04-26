<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午4:17
 */

namespace common\modules\user\controllers;


use common\modules\user\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RegistrationController extends Controller
{
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'module' => $this->module
        ]);
    }
}