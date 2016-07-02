<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 上午11:52
 */

namespace modules\prettify;


use yii\base\Widget;

class Prettify extends Widget
{
    public function run()
    {
        PrettifyAsset::register($this->view);
        $script = "$('pre').addClass('prettyprint linenums');prettyPrint();";
        $this->view->registerJs($script);
    }
    public static function handle($event)
    {
        echo self::widget();
    }
}