<?php
namespace backend\assets;

use yii\web\AssetBundle;

class ContextAsset extends AssetBundle
{
    public $sourcePath = null;
    public $baseUrl = '@web/static';

    public $js = [
        'plugins/bootstrap-contextmenu.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
