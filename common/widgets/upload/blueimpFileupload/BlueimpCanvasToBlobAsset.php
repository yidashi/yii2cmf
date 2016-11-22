<?php
namespace common\widgets\upload\blueimpFileupload;

use yii\web\AssetBundle;


class BlueimpCanvasToBlobAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-canvas-to-blob';

    public $js = [
        'js/canvas-to-blob.min.js'
    ];
}
