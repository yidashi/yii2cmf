<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:14
 * Description:
 */

namespace common\modules;


use common\components\PackageInfo;

class ModuleInfo extends PackageInfo
{
    public function getModuleClass()
    {
        return $this->getNamespace() . '\\' . 'Module';
    }
}
