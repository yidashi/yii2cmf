<?php
namespace common\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

class PackageManager extends Component
{

    public $paths;

    public $type;

    public $namespace;

    public $infoClass;

    public $packages;

    public $packgeConfigName = "package-config";

    /**
     * Looks for packages in the specified directories and creates the objects
     */
    public function findAll($paths=[])
    {
        if(!empty($this->packages))
        {
            return $this->packages;
        }

        $this->packages = [];

        if(empty($paths))
        {
            $paths = $this->paths;
        }

        foreach ($paths as $path) {
            $path = \Yii::getAlias($path);
            $fileSystem = new \FilesystemIterator($path);
            foreach ($fileSystem as $item) {
                if ($item->isDir()) {
                    $path = $item;
                    if (($package = $this->findByPath($path)) == null) {
                        continue;
                    }

                    $this->packages[$package->getPackage()] = $package;
                }
            }
        }
        return $this->packages;
    }

    public function findByPath($path)
    {
        $path = new \SplFileInfo($path);
        $class = $this->namespace . $path->getBasename() . '\\' . $this->infoClass;
        if (class_exists($class)) {
            $config = [
                'class' => $class
            ];
            $package = \Yii::createObject($config);
            return $package;
        }
        return null;
    }

    public function deletePackage($package)
    {
        FileHelper::removeDirectory($package->getPath());
    }

    /**
     * @param $id
     * @return null
     */
    public function findOne($id)
    {
        $packages = $this->findAll();
        if (isset($packages[$id])) {
            return $packages[$id];
        }
        return null;
    }
}