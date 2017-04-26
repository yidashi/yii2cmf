<?php

namespace plugins\authclient\clients;

use yii\authclient\OAuth2;

class WeiboAuth extends OAuth2
{

    public $authUrl = 'https://api.weibo.com/oauth2/authorize';

    public $tokenUrl = 'https://api.weibo.com/oauth2/access_token';

    public $apiBaseUrl = 'https://api.weibo.com';

    /**
     *
     * @return array
     * @see http://open.weibo.com/wiki/Oauth2/get_token_info
     * @see http://open.weibo.com/wiki/2/users/show
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('oauth2/get_token_info', 'POST');
        $result = $this->api("2/users/show.json", 'GET', [
            'uid' => $attributes['uid']
        ]);
        $result['login'] = $result['name'];
        $result['email'] = $result['name'] . '@weibo.com';
        $result['avatar'] = $result['avatar_large'];
        return $result;
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
        return isset($this->getUserAttributes()['name']) ? $this->getUserAttributes()['name'] : null;
    }

    protected function defaultName()
    {
        return 'weibo';
    }

    protected function defaultTitle()
    {
        return '微博';
    }
}