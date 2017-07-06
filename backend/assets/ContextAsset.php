<?php
namespace backend\assets;

use yii\web\AssetBundle;

class ContextAsset extends AssetBundle
{
    public $sourcePath = '@backend/static';

    public $js = [
        'plugins/bootstrap-contextmenu.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
