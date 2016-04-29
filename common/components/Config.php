<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/27
 * Time: 下午4:07
 */

namespace common\components;


use yii\base\Component;
use yii\caching\DbDependency;
use common\models\Config as ConfigModel;

class Config extends Component
{
    public function get($name, $default = '')
    {
        $config = \Yii::$app->cache->get([__CLASS__, $name]);
        if ($config === false) {
            $config = ConfigModel::find()->where(['name' => $name])->one();
            \Yii::$app->cache->set([__CLASS__, $name], $config, 60 * 60, new DbDependency(['sql' => 'SELECT MAX(updated_at) FROM {{%config}}']));
        }
        if (!empty($config)) {
            return self::_parse($config->type, $config->value);
        } else {
            return $default;
        }
    }

    private static function _parse($type, $value)
    {
        switch ($type) {
            case ConfigModel::TYPE_ARRAY:
                $return = [];
                foreach (explode("\r\n", $value) as $val) {
                    if (strpos($val, ':') !== false) {
                        list($k, $v) = explode(':', $val);
                        $return[$k] = $v;
                    } else {
                        $return[] = $val;
                    }
                }
                $value = $return;
                break;
        }

        return $value;
    }
}