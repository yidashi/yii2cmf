<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\theme;


class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'frontend',
        'version' => 'v1.0',
        'id' => 'theme',
        'name' => '网站主题',
        'description' => '网站主题'
    ];
}