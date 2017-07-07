<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/6
 * Time: 下午3:41
 */

namespace common\modules\message;


use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\User;

class Module extends \common\modules\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app->id == 'frontend') {
            Event::on(User::className(), 'afterLogin', [$this, 'afterLogin']);
        }
    }

    public function afterLogin($event)
    {
        $sql = "SELECT * FROM {{%message_data}} d WHERE `group` = 'all' AND `id` NOT IN (SELECT `message_id` FROM {{%message}} WHERE `to_uid` = " . $event->identity->id . ")";
        $messageData = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($messageData as $item) {
            $messageModel = new \common\modules\message\models\Message();
            $messageModel->from_uid = 1;
            $messageModel->to_uid = $event->identity->id;
            $messageModel->message_id = $item['id'];
            $messageModel->read = 0;
            $messageModel->save();
            Yii::$app->notify->category('message')
                ->from(1)->to($event->identity->id)
                ->extra(['message' => $item['content']])
                ->send();
        }
    }
}