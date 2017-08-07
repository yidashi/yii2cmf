<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/12 21:55
 * Description:
 */

namespace common\modules\attachment\components\flysystem;


use League\Flysystem\Adapter\Local;
use yii\imagine\Image;

class LocalAdapter extends Local
{
    public $urlPrefix;

    public function __construct($root, $url, $writeFlags = LOCK_EX, $linkHandling = self::DISALLOW_LINKS, array $permissions = [])
    {
        parent::__construct($root, $writeFlags, $linkHandling, $permissions);
        $this->urlPrefix = $url;
    }

    protected $thumbFileRule = '_{w}_{h}';
    protected $cropFileRule = '_{w}_{h}_{x}_{y}';

    public function thumbnail($path, $width, $height)
    {
        if (strpos($path, $this->urlPrefix . '/') !== false) {
            $path = substr($path, strlen($this->urlPrefix . '/'));
        }

        $pathinfo = pathinfo($path);
        $thumbFile = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . strtr($this->thumbFileRule, ['{w}' => $width, '{h}' => $height]) . '.' . $pathinfo['extension'];
        $thumbPath = $this->pathPrefix . $thumbFile;
        if (!is_file($thumbPath)) {
            Image::thumbnail($this->pathPrefix . $path, $width, $height)->save($thumbPath);
        }
        return $this->urlPrefix . '/' . $thumbFile;
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        if (strpos($path, $this->urlPrefix . '/') !== false) {
            $path = substr($path, strlen($this->urlPrefix . '/'));
        }
        $pathinfo = pathinfo($path);
        $cropFile = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . strtr($this->cropFileRule, ['{w}' => $width, '{h}' => $height, '{x}' => $start[0], '{y}' => $start[1]]) . '.' . $pathinfo['extension'];
        $cropPath = $this->pathPrefix .  $cropFile;
        if (!is_file($cropPath)) {
            Image::thumbnail($this->pathPrefix . $path, $width, $height)->save($cropPath);
        }
        Image::crop($this->pathPrefix . $path, $width, $height, $start)->save($cropPath);
        return $this->urlPrefix . '/' . $cropFile;
    }

    public function water()
    {
        // TODO: Implement water() method.
    }
}