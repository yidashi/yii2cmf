<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/13
 * Time: 下午3:43
 */

namespace plugins\wxreply;

use Yii;

class ReplyListener
{
    public static function handle($event)
    {
        $params = Yii::$app->request->getBodyParams();
        $msgType = $params['MsgType'];
        if ($msgType == 'text') {
            $word = trim($params['Content']);
        }
        $result = $event->action->controller->renderText('你说了:' . $word);
        $event->result = $result;
    }
}