<?php
namespace backend\assets;

class SwitcherAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/static';

    public $js = [
        'plugins/switchery/switchery.min.js'
    ];

    public $css = [
        'plugins/switchery/switchery.min.css'
    ];
}