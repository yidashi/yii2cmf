<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/9
 * Time: 下午11:21
 */

namespace plugins\authclient;


use yii\web\Controller;
use common\models\Auth;
use common\models\User;
use Yii;

class AuthController extends Controller
{
    public function actions()
    {

        return [
            'index' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
                'redirectView' => '@plugins/authclient/redirect.php'
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

}