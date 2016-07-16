<?php

namespace backend\widgets\nestedsortable\assets;

use yii\web\AssetBundle;
use yii;

class NestedSortableAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__;
    }

    public $js = [
        'nested-sortable.js'
    ];
    public $css = [
        'nested-sortable.css'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
