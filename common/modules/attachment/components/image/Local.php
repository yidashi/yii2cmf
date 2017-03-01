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
    protected $thumbPathRule = '_{w}_{h}';

    public function thumbnail($path, $width, $height)
    {
        $pathinfo = pathinfo($path);
        $thumbPath = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . strtr($this->thumbPathRule, ['{w}' => $width, '{h}' => $height]) . '.' . $pathinfo['extension'];
        Image::thumbnail($path, $width, $height)->save($thumbPath);
        return $this->baseUrl . '/' . $thumbPath;
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        // TODO: Implement crop() method.
    }

    public function water()
    {
        // TODO: Implement water() method.
    }
}