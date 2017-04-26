<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace migration;


class ModuleInfo extends \common\modules\ModuleInfo
{
    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-console',
        'version' => 'v1.0',
        'id' => 'migration',
        'name' => '迁移',
        'description' => '迁移'
    ];
}