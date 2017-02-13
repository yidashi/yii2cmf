<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/27
 * Time: 下午4:07
 */

namespace common\modules\config\components;

use Yii;
use common\modules\config\models\Config as ConfigModel;
use yii\base\Component;
use yii\caching\TagDependency;
use yii\helpers\VarDumper;

class Config extends Component
{
    public $cacheKey = 'allSystemConfigs';

    public $cacheTag = 'systemConfig';

    public $localConfigFile = '@common/config/main-local.php';

    public $envFile = '@root/.env';

    public function init()
    {
        parent::init();
        $this->localConfigFile = \Yii::getAlias($this->localConfigFile);
    }

    public function get($name, $default = '')
    {
        $configs = \Yii::$app->cache->get($this->cacheKey);
        if ($configs === false) {
            $configs = ConfigModel::find()->indexBy('name')->all();
            \Yii::$app->cache->set($this->cacheKey, $configs, 60 * 60, new TagDependency(['tags' => $this->cacheTag]));
        }
        if (isset($configs[$name])) {
            $config = $configs[$name];
            return self::_parse($config->type, $config->value);
        } else {
            return env($name, $default);
        }
    }
    public function set($name, $value)
    {
        if (ConfigModel::findOne(['name' => $name]) != null) {
            $result = ConfigModel::updateAll(['value' => $value], ['name' => $name]);
            if ($result === false) {
                return false;
            }
            TagDependency::invalidate(\Yii::$app->cache, $this->cacheTag);
        } else {
            $this->setEnv($name, $value);
        }
        return true;
    }

    public function has($name)
    {
        return !is_null(ConfigModel::find()->where(['name' => $name])->one()) || getenv($name) !== false;
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
                $value = trim($value, "\r\n");
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


    public function getConfigFromLocal()
    {
        $config = require ($this->localConfigFile);

        if (! is_array($config))
            return [];
        return $config;
    }

    /**
     * Sets configuration into the file
     *
     * @param array $config
     */
    public function setConfigToLocal($config = [])
    {
        $content = "<" . "?php return ";
        $content .= VarDumper::export($config);
        $content .= ";";

        file_put_contents($this->localConfigFile, $content);
    }

    public function setEnv($name, $value)
    {
        $file = Yii::getAlias($this->envFile);
        $content = preg_replace("/({$name}\s*=)\s*(.*)/", "\${1}$value", file_get_contents($file));// \${1}修复后边跟数字的bug
        file_put_contents($file, $content);
    }
}