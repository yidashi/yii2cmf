<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/24 17:40
 * Description:
 */

namespace common\modules\attachment\components\image;


use yii\imagine\Image;

class Local extends Processor
{
    public $path;
    protected $thumbFileRule = '_{w}_{h}';
    protected $cropFileRule = '_{w}_{h}_{x}_{y}';

    public function init()
    {
        parent::init();
        $this->path = \Yii::getAlias($this->path);
    }

    public function thumbnail($path, $width, $height)
    {
        $pathinfo = pathinfo($path);
        $thumbFile = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . strtr($this->thumbFileRule, ['{w}' => $width, '{h}' => $height]) . '.' . $pathinfo['extension'];
        $thumbPath = $this->path . '/' . $thumbFile;
        Image::thumbnail($this->path . '/' . $path, $width, $height)->save($thumbPath);
        return $this->baseUrl . '/' . $thumbFile;
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        $pathinfo = pathinfo($path);
        $cropFile = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . strtr($this->cropFileRule, ['{w}' => $width, '{h}' => $height, '{x}' => $start[0], '{y}' => $start[1]]) . '.' . $pathinfo['extension'];
        $cropPath = $this->path . '/' . $cropFile;
        Image::crop($this->path . '/' . $path, $width, $height, $start)->save($cropPath);
        return $this->baseUrl . '/' . $cropFile;
    }

    public function water()
    {
        // TODO: Implement water() method.
    }
}