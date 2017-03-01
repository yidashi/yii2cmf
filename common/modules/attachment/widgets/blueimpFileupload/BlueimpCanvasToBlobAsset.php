<?php
namespace common\modules\attachment\widgets\blueimpFileupload;

use yii\web\AssetBundle;



class BlueimpCanvasToBlobAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-canvas-to-blob';

    public $js = [
        'js/canvas-to-blob.min.js'
    ];
}
