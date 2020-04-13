<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace gii;


class ModuleInfo extends \common\modules\ModuleInfo
{
    public $info = [
        'author' => '易大师',
        'bootstrap' => 'app-console',
        'version' => 'v1.0',
        'id' => 'gii',
        'name' => 'gii',
        'description' => 'gii,开发人员适用'
    ];

    public function install()
    {
        $this->addMenu('GII', 'gii/default/index', 24);
        return true;
    }

    public function uninstall()
    {
        $this->deleteMenu('GII', 24);
        return true;
    }
}