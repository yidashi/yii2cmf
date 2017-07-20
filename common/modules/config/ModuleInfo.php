<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\config;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'frontend|backend|console|api|wechat',
        'version' => 'v1.0',
        'id' => 'config',
        'name' => '动态配置',
        'description' => '动态配置'
    ];
}