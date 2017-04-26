<?php

namespace backend\widgets\grid;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the [jQuery TreeGrid plugin library](https://github.com/maxazan/jquery-treegrid)
 *
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 */
class TreeGridAsset extends AssetBundle {

    public $sourcePath = '@backend/widgets/grid/assets/tree';

    public $js = [
        'js/jquery.treegrid.min.js',
    ];

    public $css = [
        'css/jquery.treegrid.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

} 