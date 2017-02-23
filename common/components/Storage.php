<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午5:49
 */

namespace common\components;


use creocoder\flysystem\Filesystem;
use yii\base\Component;

class Storage extends Component
{
    public $baseUrl;

    /**
     * @var array|string|Filesystem
     */
    public $fs;

    public function init()
    {
        parent::init();
        $this->baseUrl = \Yii::getAlias($this->baseUrl);
        $this->fs = \Yii::createObject($this->fs);
    }

    public function getPath($filename)
    {
        return $this->fs->getAdapter()->applyPathPrefix($filename);
    }

    public function getUrl($filename)
    {
        return $this->baseUrl . '/' . $filename;
    }

    public function upload($target, $source)
    {
        return $this->fs->write($target, file_get_contents($source));
    }

}