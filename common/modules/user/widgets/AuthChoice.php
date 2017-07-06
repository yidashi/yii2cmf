<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/3/20 15:20
 * Description:
 */

namespace common\modules\user\widgets;

use common\modules\user\models\Auth;
use Yii;
use yii\authclient\ClientInterface;

class AuthChoice extends \yii\authclient\widgets\AuthChoice
{
    public function run()
    {
        list(, $url) = Yii::$app->assetManager->publish(__DIR__ . '/static');
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
        return parent::run();
    }

    public function isConnected(ClientInterface $client)
    {
        return Auth::find()->where(['user_id' => \Yii::$app->user->id])->andWhere(['source' => $client->getId()])->exists();
    }
}