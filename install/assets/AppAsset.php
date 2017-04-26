<?php
namespace install\assets;

class AppAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@install/static';

    public $js = [
        'js/loading-overlay.min.js',
        'js/install.js'
    ];
    public $css = [
        'css/loading-overlay.css',
        'css/install.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
    ];

}
