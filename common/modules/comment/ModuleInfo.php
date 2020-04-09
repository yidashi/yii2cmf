<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2020/4/8 12:04
 * Description:
 */

namespace common\modules\comment;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => '',
        'version' => 'v1.0',
        'id' => 'comment',
        'name' => '评论管理',
        'description' => '评论管理'
    ];
}