<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/20
 * Time: 上午10:25
 */

namespace common\components;


use plugins\Plugins;

class ModuleManager extends PackageManager
{
    public $paths = [
        '@common/modules'
    ];

    public $namespace = 'common\\modules\\';

    public $infoClass = 'Module';

}