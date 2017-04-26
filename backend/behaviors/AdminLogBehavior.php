<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/25
 * Time: 下午12:25
 */

namespace backend\behaviors;


use common\models\AdminLog;
use Yii;
use yii\base\Application;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, [$this, 'log']);
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, [$this, 'log']);
    }

    public function log($event)
    {
        if($event->sender instanceof AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增了表%s %s:%s的%s";
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改了表%s %s:%s的%s";
        } else {
            $description = "%s删除了表%s %s:%s%s";
        }
        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }
        $userName = Yii::$app->user->identity->username;
        $tableName = $event->sender->tableSchema->name;
        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], is_array($event->sender->getPrimaryKey()) ? current($event->sender->getPrimaryKey()) : $event->sender->getPrimaryKey(), $desc);

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