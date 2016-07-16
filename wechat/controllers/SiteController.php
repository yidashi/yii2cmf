<?php

namespace wechat\controllers;

use common\models\Mp;
use common\models\WxUser;
use Yii;
use yii\base\Event;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/20
 * Time: 下午2:58
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->method == 'GET') {
            if (!$this->checkSignature()) {
                throw new BadRequestHttpException('非法请求');
            }
            echo Yii::$app->request->get('echostr');
            exit;
        }
        $params = Yii::$app->request->getBodyParams();
        return;
    }

    private function checkSignature()
    {
        $signature = Yii::$app->request->get('signature');
        $timestamp = Yii::$app->request->get('timestamp');
        $nonce = Yii::$app->request->get('nonce');

        $token = Yii::$app->config->get('wx_token');
        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature;
    }

}
