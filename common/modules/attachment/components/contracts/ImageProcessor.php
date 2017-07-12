<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/2/24 17:39
 * Description:
 */

namespace common\modules\attachment\components\contracts;


interface ImageProcessor
{
    public function thumbnail($path, $width, $height);

    public function crop($path, $width, $height, array $start = [0,0]);

//    abstract function water();
}