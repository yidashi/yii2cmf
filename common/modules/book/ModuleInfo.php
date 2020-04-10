<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/17 12:04
 * Description:
 */

namespace common\modules\book;

class ModuleInfo extends \common\modules\ModuleInfo
{
    public $info = [
        'author' => '易大师',
        'bootstrap' => '',
        'version' => 'v1.0',
        'id' => 'book',
        'name' => '书籍',
        'description' => '书籍'
    ];

    public function install()
    {
        $migrate = new Migrate();
        $migrate->up();
        $this->addMenu('书籍', '/book/default/index', 39);
        return true;
    }

    public function uninstall()
    {
        $migrate = new Migrate();
        $migrate->down();
        $this->deleteMenu('书籍');
        return true;
    }
}