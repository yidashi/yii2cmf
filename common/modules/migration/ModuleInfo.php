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
        'bootstrap' => 'console',
        'version' => 'v1.0',
        'id' => 'migration',
        'name' => '数据库迁移',
        'description' => '数据库迁移'
    ];

    public function install()
    {
        $this->addMenu('数据库迁移', '/migration/default/index', 24);
        return true;
    }

    public function uninstall()
    {
        $this->deleteMenu('数据库迁移');
        return true;
    }
}