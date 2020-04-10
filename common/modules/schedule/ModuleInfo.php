<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2020/4/8 12:04
 * Description:
 */

namespace common\modules\schedule;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $isCore = 0;

    public $info = [
        'author' => '易大师',
        'bootstrap' => '',
        'version' => 'v1.0',
        'id' => 'schedule',
        'name' => '任务调度',
        'description' => '任务调度'
    ];


    public function install()
    {
        $migrate = new Migrate();
        $migrate->up();
        $this->addMenu('任务调度', '/schedule/default/index', 24);
        return true;
    }

    public function uninstall()
    {
        $migrate = new Migrate();
        $migrate->down();
        $this->deleteMenu('任务调度');
        return true;
    }
}