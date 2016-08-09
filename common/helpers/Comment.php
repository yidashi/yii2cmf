<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/13
 * Time: 下午2:23
 */

namespace common\helpers;


use common\modules\user\models\User;

class Comment
{
    public static function process($data)
    {
        preg_match('/@(\S+?)\s/', $data, $matches);
        if (!empty($matches)) {
            $replyUserName = $matches[1];
            $replyUserId = User::find()->select('id')->where(['username' => $replyUserName])->scalar();
            $data = preg_replace('/(@\S+?\s)/', Html::a('$1', ['/user/default/index', 'id' => $replyUserId]), $data);
        }
        return $data;
    }
}