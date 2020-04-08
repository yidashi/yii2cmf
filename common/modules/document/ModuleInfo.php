<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2020/4/8 12:04
 * Description:
 */

namespace common\modules\document;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => '',
        'version' => 'v1.0',
        'id' => 'document',
        'name' => '内容管理',
        'description' => '内容管理'
    ];
}