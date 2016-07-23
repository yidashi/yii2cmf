<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/9
 * Time: 下午11:11
 */

namespace plugins\authclient;
use Yii;


class AfterLoginListener
{
    public static function handle($event)
    {
        if (Yii::$app->has('authClientCollection')) {
            list(, $url) = Yii::$app->assetManager->publish('@plugins/authclient/assets');
            Yii::$app->view->registerCss(<<<CSS
.auth-icon.QQ {
    background: url({$url}/qq.png) no-repeat;
    background-size: 32px 32px;
}
.auth-icon.weibo {
    background: url({$url}/weibo.png) no-repeat;
    background-size: 32px 32px;
}
.auth-icon.weixin {
    background: url({$url}/weixin.png) no-repeat;
    background-size: 32px 32px;
}
CSS
            );
            echo \yii\authclient\widgets\AuthChoice::widget([
                'id' => 'auth-login',
                'baseAuthUrl' => ['/auth'],
                'popupMode' => true,
            ]);
        }
    }
}