<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午5:49
 */

namespace common\modules\attachment\components;


use common\modules\attachment\components\image\Processor;
use creocoder\flysystem\Filesystem;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Storage extends Component
{
    public $baseUrl;

    /**
     * @var array|string|Filesystem
     */
    public $fs;
    /**
     * @var array|string|Processor
     */
    public $imageProcessor;

    public function init()
    {
        parent::init();
        $this->baseUrl = \Yii::getAlias($this->baseUrl);
        $this->fs = \Yii::createObject($this->fs);
        $this->imageProcessor = \Yii::createObject(ArrayHelper::merge($this->imageProcessor, ['baseUrl' => $this->baseUrl]));
    }

    public function getPath($url)
    {
        return trim(str_replace($this->baseUrl, '', $url), '/');
    }

    public function getUrl($filename)
    {
        return $this->baseUrl . '/' . $filename;
    }

    public function upload($target, $source)
    {
        return $this->fs->put($target, file_get_contents($source));
    }

    public function thumbnail($path, $width, $height)
    {
        return $this->imageProcessor->thumbnail($path, $width, $height);
    }

    public function crop($path, $width, $height, $start = [0, 0])
    {
        return $this->imageProcessor->crop($path, $width, $height, $start);
    }

}