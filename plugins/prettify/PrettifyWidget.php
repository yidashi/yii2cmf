<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:27
 */

namespace plugins\prettify;


use yii\base\Widget;

class PrettifyWidget extends Widget
{
    public function run()
    {
        PrettifyAsset::register($this->view);
        $script = "$('pre').addClass('prettyprint linenums');prettyPrint();";
        $this->view->registerJs($script);
    }
}