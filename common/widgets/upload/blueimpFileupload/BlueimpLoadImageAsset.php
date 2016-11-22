<?php
namespace common\widgets\upload\blueimpFileupload;

use yii\web\AssetBundle;

class BlueimpLoadImageAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-load-image';

    public $js = [
        'js/load-image.all.min.js'
    ];
}
