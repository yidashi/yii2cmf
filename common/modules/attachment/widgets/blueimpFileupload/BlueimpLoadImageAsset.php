<?php
namespace common\modules\attachment\widgets\blueimpFileupload;

use yii\web\AssetBundle;

class BlueimpLoadImageAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-load-image';

    public $js = [
        'js/load-image.all.min.js'
    ];
}
