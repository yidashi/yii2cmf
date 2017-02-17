<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\message;


use common\components\PackageInfo;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-frontend|app-backend',
        'version' => 'v1.0',
        'id' => 'message',
        'name' => '站内信',
        'description' => '站内信'
    ];
}