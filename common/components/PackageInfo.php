<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午11:31
 */

namespace common\components;


use yii\base\Object;

class PackageInfo extends Object
{
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
}