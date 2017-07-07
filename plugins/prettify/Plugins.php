<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午1:46
 */

namespace plugins\prettify;


use yii\base\BootstrapInterface;
use yii\web\View;
use yii\base\Event;

class Plugins extends \plugins\Plugins implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'prettify',
        'name' => '代码高亮',
        'description' => '代码高亮模块'
    ];

    public function bootstrap($app)
    {
        Event::on(View::className(), 'afterComment', [$this, 'run']);
        Event::on(View::className(), 'afterArticleView', [$this, 'run']);
    }

    public function run()
    {
        PrettifyAsset::register($this->view);
        $script = "$('pre').addClass('prettyprint linenums');prettyPrint();";
        $this->view->registerJs($script);
    }
}