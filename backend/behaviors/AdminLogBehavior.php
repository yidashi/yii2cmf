<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/25
 * Time: 下午12:25
 */

namespace backend\behaviors;


use yii\base\Application;
use yii\base\Behavior;
use Yii;
use yii\helpers\Url;
use yii\base\Event;
use yii\db\ActiveRecord;
use common\models\AdminLog;

class AdminLogBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'handle'
        ];
    }
    public function handle()
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, [$this, 'log']);
    }

    public function log($event)
    {
        // 显示详情有待优化,不过基本功能完整齐全
        if(!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
            $description = Yii::$app->user->identity->username . '修改了表' . $event->sender->tableSchema->name . ' ' . $event->sender->primaryKey()[0] . ':' . $event->sender->getPrimaryKey() . '的' . $desc;
            $route = Url::to();
            $userId = Yii::$app->user->id;
            $ip = ip2long(Yii::$app->request->userIP);
            $data = [
                'route' => $route,
                'description' => $description,
                'user_id' => $userId,
                'ip' => $ip
            ];
            $model = new AdminLog();
            $model->setAttributes($data);
            $model->save();
        }
    }
}