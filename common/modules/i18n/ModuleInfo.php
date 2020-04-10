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
    public $isCore = 0;

    public $info = [
        'author' => '易大师',
        'bootstrap' => 'frontend|backend|api',
        'version' => 'v1.0',
        'id' => 'i18n',
        'name' => '国际化',
        'description' => '国际化'
    ];

    public function install()
    {
        $migrate = new Migrate();
        $migrate->up();
        $this->addMenu('国际化源信息', '/i18n/i18n-source-message/index', 24);
        $this->addMenu('国际化信息', '/i18n/i18n-message/index', 24);
        return true;
    }

    public function uninstall()
    {
        $migrate = new Migrate();
        $migrate->down();
        $this->deleteMenu('国际化源信息');
        $this->deleteMenu('国际化信息');
        return true;
    }
}