<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/24 17:41
 * Description:
 */

namespace common\modules\attachment\components\image;


use Qiniu\Processing\ImageUrlBuilder;

class Qiniu extends Processor
{
    public function thumbnail($path, $width, $height)
    {
        $imageBuilder = new ImageUrlBuilder();
        return $imageBuilder->thumbnail($this->baseUrl . '/' . $path, 1, $width, $height);
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        return $this->baseUrl . '/' . $path . '?imageMogr2/crop/!' . $width . 'x' . $height . 'a' . $start[0] . 'a' . $start[1];
    }

    public function water()
    {
        // TODO: Implement water() method.
    }
}