<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\i18n;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'frontend|backend|api',
        'version' => 'v1.0',
        'id' => 'i18n',
        'name' => 'i18n',
        'description' => '国际化'
    ];
}