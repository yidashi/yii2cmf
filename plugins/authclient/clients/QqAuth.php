<?php
namespace plugins\authclient\clients;

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


    /**
     * 该扩展初始的处理方法似乎QQ互联不能用，应此改写了方法
     * @deprecated authclient since 2.1.0
     * @see \yii\authclient\BaseOAuth::processResponse()
     */
    protected function processResponse($rawResponse, $contentType = self::CONTENT_TYPE_AUTO)
    {
        if (empty($rawResponse)) {
            return [];
        }
        switch ($contentType) {
            case self::CONTENT_TYPE_AUTO: {
                $contentType = $this->determineContentTypeByRaw($rawResponse);
                if ($contentType == self::CONTENT_TYPE_AUTO) {
                    //以下代码是特别针对QQ互联登录的，也是与原方法不一样的地方
                    if(strpos($rawResponse, "callback") !== false){
                        $lpos = strpos($rawResponse, "(");
                        $rpos = strrpos($rawResponse, ")");
                        $rawResponse = substr($rawResponse, $lpos + 1, $rpos - $lpos -1);
                        $response = $this->processResponse($rawResponse, self::CONTENT_TYPE_JSON);
                        break;
                    }
                    //代码添加结束
                    throw new Exception('Unable to determine response content type automatically.');
                }
                $response = $this->processResponse($rawResponse, $contentType);
                break;
            }
            case self::CONTENT_TYPE_JSON: {
                $response = Json::decode($rawResponse, true);
                if (isset($response['error'])) {
                    throw new Exception('Response error: ' . $response['error']);
                }
                break;
            }
            case self::CONTENT_TYPE_URLENCODED: {
                $response = [];
                parse_str($rawResponse, $response);
                break;
            }
            case self::CONTENT_TYPE_XML: {
                $response = $this->convertXmlToArray($rawResponse);
                break;
            }
            default: {
            throw new Exception('Unknown response type "' . $contentType . '".');
            }
        }

        return $response;
    }


}
