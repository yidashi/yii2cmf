<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/20
 * Time: 下午3:05
 */

namespace wechat\controllers;


class Controller extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['contentNegotiator']['formats']['application/json']);
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    /**
     * 回复文字
     * @param $text
     * @return array
     */
    public function renderText($text)
    {
        return [
            'ToUserName' => \Yii::$app->request->bodyParams['FromUserName'], //接收方帐号（收到的OpenID）
            'FromUserName' => \Yii::$app->request->bodyParams['ToUserName'], //开发者微信号
            'CreateTime' => time(),
            'MsgType' => 'text',
            'Content' => $text
        ];
    }

    /**
     * 回复图文
     * @param array $articles
     * @return array
     */
    public function renderNews(array $articles)
    {
        return [
            'ToUserName' => \Yii::$app->request->bodyParams['FromUserName'], //接收方帐号（收到的OpenID）
            'FromUserName' => \Yii::$app->request->bodyParams['ToUserName'], //开发者微信号
            'CreateTime' => time(),
            'MsgType' => 'news',
            'ArticleCount' => count($articles),
            'Articles' => $articles
        ];
    }
}