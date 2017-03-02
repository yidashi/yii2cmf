<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\user;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-frontend|app-backend',
        'version' => 'v1.0',
        'id' => 'user',
        'name' => '用户',
        'description' => '用户'
    ];
}