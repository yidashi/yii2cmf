<?php
/**
 * author: yidashi
 * Date: 2015/12/25
 * Time: 11:53.
 */
namespace common\models;

use Yii;

class Weixin
{
    public function getAccessToken($appId, $appSecret)
    {
        $accessToken = Yii::$app->cache->get('wxAccessToken');
        if ($accessToken === false) {
            $accessTokenRes = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}");
            $accessToken = \yii\helpers\Json::decode($accessTokenRes)['access_token'];
            Yii::$app->cache->set('wxAccessToken', $accessToken);
        }

        return $accessToken;
    }

    public function getTicket($accessToken)
    {
        $ticketRes = file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$accessToken}&type=jsapi");
        $ticket = \yii\helpers\Json::decode($ticketRes)['ticket'];

        return $ticket;
    }

    public function sign($params = [])
    {
        $signature = '';
        ksort($params);
        foreach ($params as $key => $param) {
            $signature .= $key.'='.$param.'&';
        }
        $signature = sha1(rtrim($signature, '&'));

        return $signature;
    }
}
