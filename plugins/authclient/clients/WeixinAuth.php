<?php

namespace plugins\authclient\clients;

use yii\authclient\OAuth2;


class WeixinAuth extends OAuth2
{

    public $authUrl = 'https://open.weixin.qq.com/connect/qrconnect';

    public $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    public $apiBaseUrl = 'https://api.weixin.qq.com';

    public $scope = 'snsapi_login';

    /**
     * Composes user authorization URL.
     *
     * @param array $params
     *            additional auth GET params.
     * @return string authorization URL.
     */
    public function buildAuthUrl(array $params = [])
    {
        $defaultParams = [
            'appid' => $this->clientId,
            'redirect_uri' => $this->getReturnUrl(),
            'response_type' => 'code'
        ];
        if (! empty($this->scope)) {
            $defaultParams['scope'] = $this->scope;
        }
        return $this->composeUrl($this->authUrl, array_merge($defaultParams, $params));
    }

    /**
     * Fetches access token from authorization code.
     *
     * @param string $authCode
     *            authorization code, usually comes at $_GET['code'].
     * @param array $params
     *            additional request params.
     * @return OAuthToken access token.
     */
    public function fetchAccessToken($authCode, array $params = [])
    {
        $defaultParams = [
            'appid' => $this->clientId,
            'secret' => $this->clientSecret,
            'code' => $authCode,
            'grant_type' => 'authorization_code'
        ];
        $response = $this->sendRequest('POST', $this->tokenUrl, array_merge($defaultParams, $params));
        $token = $this->createToken([
            'params' => $response
        ]);
        $this->setAccessToken($token);
        return $token;
    }

    /**
     * @inheritdoc
     */
    protected function apiInternal($accessToken, $url, $method, array $params, array $headers)
    {
        $params['access_token'] = $accessToken->getToken();
        $params['openid'] = $this->getOpenid();
        return $this->sendRequest($method, $url, $params, $headers);
    }

    /**
     *
     * @return []
     * @see https://open.weixin.qq.com/cgi-bin/showdocument?action=doc&id=open1419316518&t=0.14920092844688204
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('sns/userinfo');
        $attributes['id'] = $attributes['openid'];
        return $attributes;
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email']) ? $this->getUserAttributes()['email'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getUsername()
    {
        return isset($this->getUserAttributes()['login']) ? $this->getUserAttributes()['login'] : null;
    }

    protected function defaultName()
    {
        return 'weixin';
    }

    protected function defaultTitle()
    {
        return '微信';
    }
}