<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/3/8 14:30
 * Description:
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\LoginForm;
use api\common\models\User;


class AuthController extends Controller
{
    /**
     * @api {post} /v1/auth/login 登录
     * @apiVersion 1.0.0
     * @apiName login
     * @apiGroup Auth
     *
     * @apiParam {String} username 用户名/邮箱
     * @apiParam {String} password  密码
     *
     */
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