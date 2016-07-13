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
        $msgType = $params['MsgType'];
        if ($msgType == 'event') {
            return $this->event();
        }
        if ($msgType == 'voice') {
            $name = trim($params['Recognition'], '！');
        } elseif ($msgType == 'text') {
            $name = trim($params['Content']);
        } else {
            return $this->renderText('说人话！');
        }
        $modules = Yii::$app->getModules();
        $result = '';
        foreach ($modules as $key => $module) {
            /**
             * @var $module \yii\base\Module
             */
            $module = new $module($key, null, ['mp' => $this->mp]);
            if ($module->hasMethod('process')) {
                $result = $module->process($name);
                if ($result) {
                    break;
                }
            }
        }
        $result = $result ?: '睡觉呢,睡醒了回复你';
        return is_array($result) ? $this->renderNews($result) : $this->renderText($result);

    }

    public function event()
    {
        if (Yii::$app->request->bodyParams['Event'] == 'subscribe') {
            // 添加到关注表
            $user = WxUser::find()->where(['mp_id' => $this->mp->id, 'openid' => Yii::$app->request->bodyParams['FromUserName']])->one();
            if (empty($user)) {
                $user = new WxUser();
                $user->attributes = [
                    'openid' => Yii::$app->request->bodyParams['FromUserName'],
                    'mp_id' => $this->mp->id,
                    'is_subscribe' => 1
                ];
                $user->save();
            } else {
                $user->is_subscribe = 1;
                $user->save();
            }
            return $this->renderText($this->mp->subscribe);
        } elseif (Yii::$app->request->bodyParams['Event'] == 'unsubscribe') {
            $user = WxUser::find()->where(['mp_id' => $this->mp->id, 'openid' => Yii::$app->request->bodyParams['FromUserName']])->one();
            $user->is_subscribe = 0;
            $user->save();
        }
        return [];
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
