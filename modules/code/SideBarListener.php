<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 下午12:00
 */

namespace modules\code;


use yii\base\Widget;

class SideBarListener extends Widget
{
    public static function handle($event)
    {
        echo self::widget();
    }
    public function run()
    {
        return $this->render('sideBar');
    }
}