<?php

namespace common\widgets\upload;

use yii\web\AssetBundle;

class ImageUploadAsset extends AssetBundle
{

    public $sourcePath = '@common/widgets/upload/assets';

    public $css = [
        'image-upload.css'
    ];

    public $js = [
        'image-upload.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\upload\blueimpFileupload\BlueimpFileuploadAsset'
    ];
}
