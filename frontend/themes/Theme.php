<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/19
 * Time: 上午12:08
 */

namespace frontend\themes;


use backend\components\ThemeManager;
use yii\base\Object;

abstract class Theme extends Object
{
    public $manager;
    public function __construct(ThemeManager $manager, array $config = [])
    {
        $this->manager = $manager;
        parent::__construct($config);
    }

    public function isActive()
    {
        return $this->getPackage() == $this->manager->getDefaultTheme();
    }

    public function getPackage()
    {
        return $this->info['id'];
    }
    public function getTitle()
    {
        return $this->info['title'];
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