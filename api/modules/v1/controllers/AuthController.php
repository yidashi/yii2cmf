<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/8 14:30
 * Description:
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\LoginForm;
use api\common\models\User;


class AuthController extends Controller
{
    public function  actionLogin()
    {
        $model = new LoginForm();
        $model->load(request()->post(), '');

        if ($model->login()) {
            /**
             * @var User $user
             */
            $user = \Yii::$app->user->identity;
            if (empty($user->access_token) || $user->expired_at < time()) {
                $user->generateAccessToken();
                $user->save(false);
            }
            return ['user' => $user];
        } else {
            return $model;
        }

    }

    public function  actionLoginout()
    {

        if (\Yii::$app->user->logout()) {
            return [];
        }
    }
}