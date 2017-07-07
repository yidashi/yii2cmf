<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午11:31
 */

namespace common\components;


use common\models\Module;
use yii\base\Object;
use Yii;
use yii\helpers\Json;

/**
 * @property string $author
 * @property string $version
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $package
 */
abstract class PackageInfo extends Object
{
    public $info = [
        'author' => '',
        'version' => '',
        'name' => '',
        'title' => '',
        'desc' => ''
    ];

    final public function checkInfo(){
        $info_check_keys = ['id','name','description','author','version'];
        foreach ($info_check_keys as $value) {
            if(!array_key_exists($value, $this->info))
                return false;
        }
        return true;
    }

    /**
     * @var string 配置文件名
     */
    public $configFile = '';

    public function init()
    {
        if (empty($this->configFile)) {
            $class = new \ReflectionClass($this);
            $this->configFile = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'config.php';

        }
    }

    private $_config = [];

    /**
     * 获取插件初始配置
     * @return array|mixed
     */
    final public function getInitConfig()
    {
        if (is_file($this->configFile)) {
            $this->_config = include $this->configFile;
        }
        return $this->_config;
    }

    /**
     * 获取插件当前配置
     * @return array|mixed
     */
    final public function getConfig()
    {
        $model = $this->getModel();
        $configs = Json::decode($model->config);
        $c = [];
        if (!empty($configs)) {
            foreach ($configs as $k => $config) {
                $c[$config['name']] = $config['value'];
            }
        }
        return $c;
    }

    public function getPath()
    {
        $class = new \ReflectionClass($this);
        return dirname($class->getFileName());
    }
    public function getNamespace()
    {
        $class = new \ReflectionClass($this);
        return $class->getNamespaceName();
    }
    public function getPackage()
    {
        return $this->info['id'];
    }
    public function getName()
    {
        return isset($this->info['name']) ? $this->info['name'] : '';
    }
    public function getBootstrap()
    {
        return isset($this->info['bootstrap']) ? $this->info['bootstrap'] : '';
    }

    public function getAuthor()
    {
        return isset($this->info['author']) ? $this->info['author'] : '';
    }
    public function getVersion()
    {
        return isset($this->info['version']) ? $this->info['version'] : '';
    }
    public function getDescription()
    {
        return isset($this->info['description']) ? $this->info['description'] : '';
    }

    public function getKeywords()
    {
        return isset($this->info['keywords']) ? $this->info['keywords'] : '';
    }
    public function getScreenshot()
    {
        $class = new \ReflectionClass($this);

        $screenshot = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'screenshot.png';
        $url = "";
        if (file_exists($screenshot)) {
            list (, $url) = \Yii::$app->getAssetManager()->publish($screenshot);
        }
        return $url;
    }

    private $_model;

    /**
     * @return Module
     */
    public function getModel()
    {
        if ($this->_model == null) {
            $model = Module::findOne($this->getPackage());
            if ($model == null) {
                $model = new Module();
                $model->loadDefaultValues();
                $model->id = $this->getPackage();
            }
            $this->_model = $model;
        }
        return $this->_model;
    }
    public function getInstall()
    {
        return $this->getModel()->getInstall();
    }
    public function getOpen()
    {
        return $this->getModel()->getOpen();
    }
    public function canUninstall()
    {
        return $this->getModel()->install === true;
    }

    public function canClose()
    {
        return $this->getModel()->is_core == false;
    }

}