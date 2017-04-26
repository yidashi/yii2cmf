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
        'bootstrap' => 'app-frontend|app-backend|app-api',
        'version' => 'v1.0',
        'id' => 'i18n',
        'name' => 'i18n',
        'description' => '国际化'
    ];

    public function install()
    {
        return $this->addMenu('国际化源信息', '/i18n/i18n-source-message/index') && $this->addMenu('国际化信息', '/i18n/i18n-message/index');
    }

    public function uninstall()
    {
        return $this->deleteMenu('国际化源信息') && $this->deleteMenu('国际化信息');
    }

    public function open()
    {
        return $this->addMenu('国际化源信息', '/i18n/i18n-source-message/index') && $this->addMenu('国际化信息', '/i18n/i18n-message/index');
    }

    public function close()
    {
        return $this->deleteMenu('国际化源信息') && $this->deleteMenu('国际化信息');
    }
}