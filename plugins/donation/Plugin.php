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

class Plugin extends \plugins\Plugin
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
        if (parent::install()) {
            $class = new Migrate();
            $class->up();
            $this->addMenu('捐赠', '/donation/index');
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        if (parent::uninstall()) {
            $class = new Migrate();
            $class->down();
            $this->deleteMenu('捐赠');
            return true;
        }
        return false;
    }
}