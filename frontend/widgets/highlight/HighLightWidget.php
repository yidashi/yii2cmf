<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 上午11:52
 */

namespace frontend\widgets\highlight;


use yii\base\Widget;

class HighLightWidget extends Widget
{
    public function run()
    {
        HighLightAsset::register($this->view);
        $script = "hljs.initHighlightingOnLoad();";
        $this->view->registerJs($script);
    }
}