<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/6
 * Time: 下午9:50
 */
namespace common\modules\urlrule;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 1;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-frontend|app-backend',
        'version' => 'v1.0',
        'id' => 'urlrule',
        'name' => 'url规则',
        'description' => 'url规则'
    ];
}