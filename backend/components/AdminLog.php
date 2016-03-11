<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace backend\components;

use Yii;
use yii\helpers\Url;

class AdminLog
{
    public static function write($event)
    {
        // 显示详情有待优化,不过基本功能完整齐全
        if(!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
            $description = Yii::$app->user->identity->username . '修改了表' . $event->sender->tableSchema->name . ' id:' . $event->sender->id . '的' . $desc;
            $route = Url::to();
            $userId = Yii::$app->user->id;
            $ip = ip2long(Yii::$app->request->userIP);
            $data = [
                'route' => $route,
                'description' => $description,
                'user_id' => $userId,
                'ip' => $ip
            ];
            $model = new \common\models\AdminLog();
            $model->setAttributes($data);
            $model->save();
        }
    }
}
