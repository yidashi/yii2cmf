<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午3:43
 */

namespace plugins\wxfollow;

use Yii;
use common\models\WxUser;

class FollowListener
{
    public static function handle($event)
    {
        $controller = $event->sender;
        $params = Yii::$app->request->getBodyParams();
        $config = $event->data;
        $msgType = $params['MsgType'];
        if ($msgType == 'event') {
            if (Yii::$app->request->bodyParams['Event'] == 'subscribe') {
                // 添加到关注表
                /*$user = WxUser::find()->where(['openid' => Yii::$app->request->bodyParams['FromUserName']])->one();
                if (empty($user)) {
                    $user = new WxUser();
                    $user->attributes = [
                        'openid' => Yii::$app->request->bodyParams['FromUserName'],
                        'is_subscribe' => 1
                    ];
                    $user->save();
                } else {
                    $user->is_subscribe = 1;
                    $user->save();
                }*/

                $event->result = $controller->renderText($config['follow.text']);
            } elseif (Yii::$app->request->bodyParams['Event'] == 'unsubscribe') {
                /*$user = WxUser::find()->where(['openid' => Yii::$app->request->bodyParams['FromUserName']])->one();
                $user->is_subscribe = 0;
                $user->save();*/
            }
        }
    }
}