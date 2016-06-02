<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 上午11:52
 */

namespace frontend\widgets\prettify;


use yii\base\Widget;

class PrettifyWidget extends Widget
{
    public function run()
    {
        PrettifyAsset::register($this->view);
        $script = "prettyPrint();";
        $this->view->registerJs($script);
    }
}