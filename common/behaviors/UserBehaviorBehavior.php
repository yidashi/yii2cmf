<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/11/21 13:24
 * Description:
 */

namespace common\behaviors;


use common\modules\user\models\Profile;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use Yii;
use common\models\UserBehaviorLog as Log;

/**
 * 记录用户行为
 */
class UserBehaviorBehavior extends Behavior
{
    const RULE = '/\{(.+?)(?:\{(.+)\})?\}/';

    public $name;

    public $eventName = [];

    /**
     * @var array 触发规则
        ```
        [
            'cycle' => 24,
            'max' => 1,
            'counter' => 10,
        ]
        ```
     */
    public $rule;
    /**
     * @var array 附加数据
     */
    public $data = [];
    /**
     * @var string 日志内容格式
     */
    public $content;

    public function events()
    {
        $events = [];
        $this->eventName = (array) $this->eventName;
        foreach ($this->eventName as $eventName) {
            $events[$eventName] = 'execute';
        }
        return $events;
    }

    public function execute()
    {
        //执行行为规则
        $execCount = Log::find()->where(['behavior_name' => $this->name, 'user_id' => Yii::$app->user->identity->id])->andWhere(['>', 'created_at', time() - intval($this->rule['cycle']) * 3600])->count();
        if($execCount >= $this->rule['max']){
            return;
        }
        // TODO 暂时只支持更新money字段
        Profile::updateAllCounters(['money' => $this->rule['counter']], ['user_id' => Yii::$app->user->identity->id]);
        //记录日志
        $this->log();
    }

    private function log()
    {
        $this->parseContent($this->data);
        $log = new Log();
        $log->behavior_name = $this->name;
        $log->user_id = Yii::$app->user->identity->id;
        $log->content = $this->content;
        $log->save(false);
    }

    protected function parseContent($data)
    {
        $data = array_merge(['user' => Yii::$app->user->identity], $data);
        $specialValues = $this->getValues($this->content);
        if (count($specialValues) > 0) {
            $specialValues = array_filter($specialValues, function ($value) {
                return StringHelper::startsWith($value, 'extra.') || StringHelper::startsWith($value, 'user.');
            });
            foreach ($specialValues as $replacer) {
                $replace = ArrayHelper::getValue($data, $replacer);
                $this->content = $this->replaceContent($this->content, $replace, $replacer);
            }
        }
    }

    protected function getValues($body)
    {
        $values = [];
        preg_match_all(self::RULE, $body, $values);

        return $values[1];
    }

    protected function replaceContent($body, $valueMatch, $replacer)
    {
        $body = str_replace('{'.$replacer.'}', $valueMatch, $body);

        return $body;
    }
}