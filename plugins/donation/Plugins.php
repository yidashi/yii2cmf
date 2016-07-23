<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午1:46
 */

namespace plugins\donation;


use plugins\donation\controllers\AdminController;
use plugins\donation\controllers\DefaultController;
use yii\web\View;
use plugins\donation\migrations\Migrate;

class Plugins extends \plugins\Plugins
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'donation',
        'name' => '捐赠',
        'description' => '捐赠模块'
    ];

    public function frontend($app)
    {
        $app->controllerMap['donation'] = [
            'class' => DefaultController::className(),
            'viewPath' => '@plugins/donation/views/default'
        ];
    }

    public function backend($app)
    {
        $app->controllerMap['donation'] = [
            'class' => AdminController::className(),
            'viewPath' => '@plugins/donation/views/admin'
        ];
    }

    public function install()
    {
        parent::install();
        $class = new Migrate();
        $class->up();
        $this->addMenu('捐赠', '/donation/index');

    }

    public function uninstall()
    {
        parent::uninstall();
        $class = new Migrate();
        //避免数据被删除,演示站卸载时候表还是不删了
//        $class->down();
        $this->deleteMenu('捐赠');
    }
}