<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\attachment;


class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-frontend|app-backend|app-api',
        'version' => 'v1.0',
        'id' => 'attachment',
        'name' => '附件',
        'description' => '附件'
    ];
}