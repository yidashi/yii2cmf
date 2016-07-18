<?php

namespace common\widgets\upload;

use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{

    public $sourcePath = '@common/widgets/upload/assets';

    public $css = [
        'file-upload.css'
    ];

    public $js = [
        'file-upload.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\upload\blueimpFileupload\BlueimpFileuploadAsset'
    ];
}
