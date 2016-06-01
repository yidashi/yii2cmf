<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/1
 * Time: 上午10:17
 */

namespace frontend\controllers;


use common\models\Sign;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SignController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $sign = Sign::find()->where(['user_id' => Yii::$app->user->id])->one();
            if (empty($sign)) {
                $sign = new Sign();
                $sign->last_sign_at = time();
                $sign->user_id = Yii::$app->user->id;
                $sign->times = 1;
                $sign->continue_times = 1;
                $sign->save();
            } else {
                if (date('Ymd', $sign->last_sign_at) != date('Ymd')) {
                    $sign->last_sign_at = time();
                    $sign->times += 1;
                    // 如果上次签到是昨天,连续签到
                    if (date('Ymd', $sign->last_sign_at) == date('Ymd', time() - 60 * 60 *24)) {
                        $sign->continue_times += 1;
                    } else {
                        $sign->continue_times = 1;
                    }
                    $sign->save();
                }
            }
            return [
                'days' => $sign->continue_times
            ];
        } else {
            return $this->render('index', [

            ]);
        }
    }
}