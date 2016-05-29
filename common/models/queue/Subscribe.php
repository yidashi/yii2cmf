<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/20
 * Time: 上午10:03
 */

namespace common\models\queue;


use yii\helpers\Html;

class Subscribe
{
    public function perform()
    {
        $args = $this->args;
        $article = unserialize($args['article']);
        \Yii::$app->mailer->compose()
            ->setFrom('13353791538@163.com')
            ->setTo('liujuntaor@qq.com')
            ->setSubject($article->title . '-' . \Yii::$app->config->get('SITE_NAME'))
            ->setTextBody($article->desc)
            ->setHtmlBody($article->desc . '<a href="http://www.51siyuan.cn/" . $article->id . ".html">阅读全文</a>')
            ->send();
    }
}