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
    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-frontend',
        'version' => 'v1.0',
        'id' => 'urlrule',
        'name' => 'url规则',
        'description' => 'url规则'
    ];

    public function install()
    {
        return $this->addMenu('路由规则', '/urlrule/admin/index');
    }

    public function uninstall()
    {
        return $this->deleteMenu('路由规则');
    }

    public function open()
    {
        return $this->addMenu('路由规则', '/urlrule/admin/index');
    }

    public function close()
    {
        return $this->deleteMenu('路由规则');
    }
}