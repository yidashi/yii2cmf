<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/24 17:39
 * Description:
 */

namespace common\modules\attachment\components\image;


use yii\base\Component;

abstract class Processor extends Component
{
    public $baseUrl;

    abstract public function thumbnail($path, $width, $height);

    abstract public function crop($path, $width, $height, array $start = [0,0]);

    abstract function water();
}