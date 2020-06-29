<?php

namespace frontend\themes\basic\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $sourcePath = null;
    public $baseUrl = '@web/themes/basic';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/drag.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\ModalAsset',
    ];
}
