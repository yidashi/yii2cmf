<?php

namespace common\modules\user\clients;

use yii\authclient\OAuth2;
use yii\base\Exception;
use yii\helpers\Json;

class QqAuth extends OAuth2
{
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';
    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';
    public $apiBaseUrl = 'https://graph.qq.com';

    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(',', [
                'get_user_info',
            ]);
        }
    }

    protected function initUserAttributes()
    {
        // 因为authclient升级导致processResponse方法没有了，QQ获取openid这个接口的返回又很奇葩，是个jsonp格式，httpclient又不支持

        $openid = $this->getOpenId();
        $qquser = $this->api("user/get_user_info", 'GET', ['oauth_consumer_key'=>$openid['client_id'], 'openid'=>$openid['openid']]);
        $qquser['openid'] = $openid['openid'];
        $qquser['id'] = $qquser['openid'];
        $qquser['login'] = $qquser['nickname'];
        $qquser['email'] = $qquser['nickname'] . '@qq.com';
        $qquser['avatar'] = $qquser['figureurl_qq_2'];
        return $qquser;
    }

    public function getOpenId()
    {
        $request = $this->createApiRequest()
            ->setMethod('get')
            ->setUrl('oauth2.0/me');

        $response = $request->send();
        $rawResponse = $response->getContent();
        if(strpos($rawResponse, "callback") !== false){
            $lpos = strpos($rawResponse, "(");
            $rpos = strrpos($rawResponse, ")");
            $rawResponse = substr($rawResponse, $lpos + 1, $rpos - $lpos -1);
            $openid = Json::decode($rawResponse);
            return $openid;
        }
        return false;
    }
    protected function defaultName()
    {
        return 'QQ';
    }

    protected function defaultTitle()
    {
        return 'QQ';
    }
}
