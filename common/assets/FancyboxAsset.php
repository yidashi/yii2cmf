<?php
namespace common\assets;

use yii\web\AssetBundle;


class FancyboxAsset extends AssetBundle
{
    public $sourcePath = '@common/static/fancybox';
    public $css = [
        'jquery.fancybox.css',
        'helpers/jquery.fancybox-buttons.css',
        'helpers/jquery.fancybox-thumbs.css'
    ];
    public $js = [
        'jquery.fancybox.js',
        'helpers/jquery.fancybox-buttons.js',
        'helpers/jquery.fancybox-thumbs.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
