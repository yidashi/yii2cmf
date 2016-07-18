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
use yii\caching\TagDependency;

class Config extends Component
{
    public function get($name, $default = '')
    {
        $cacheKey = 'allSystemConfigs';
        $configs = \Yii::$app->cache->get($cacheKey);
        if ($configs === false) {
            $configs = ConfigModel::find()->indexBy('name')->all();
            \Yii::$app->cache->set($cacheKey, $configs, 60 * 60, new TagDependency(['tags' => 'systemConfig']));
        }
        if (isset($configs[$name])) {
            $config = $configs[$name];
            return self::_parse($config->type, $config->value);
        } else {
            return env($name, $default);
        }
    }

    /**
     * 解析数组类型配置
     * @param $type
     * @param $value
     * @return array
     */
    private static function _parse($type, $value)
    {
        switch ($type) {
            case ConfigModel::TYPE_ARRAY:
                $return = [];
                foreach (explode("\r\n", $value) as $val) {
                    if (strpos($val, '=>') !== false) {
                        list($k, $v) = explode('=>', $val);
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