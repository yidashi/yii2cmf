<?php
namespace common\assets;

use yii\web\AssetBundle;


class FancyboxAsset extends AssetBundle
{
    public $sourcePath = '@common/static';
    public $css = [
        'fancybox/jquery.fancybox.css',
        'fancybox/helpers/jquery.fancybox-buttons.css',
        'fancybox/helpers/jquery.fancybox-thumbs.css'
    ];
    public $js = [
        'fancybox/jquery.fancybox.js',
        'fancybox/helpers/jquery.fancybox-buttons.js',
        'fancybox/helpers/jquery.fancybox-thumbs.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
