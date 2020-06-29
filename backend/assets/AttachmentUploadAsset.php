<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AttachmentUploadAsset extends AssetBundle
{
    public $sourcePath = null;
    public $baseUrl = '@web/static';
    public $css = [
        'attachment-upload.css',
    ];
    public $js = [
        'attachment-upload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\upload\blueimpFileupload\BlueimpFileuploadAsset',
        'backend\assets\AppAsset'
    ];
}

?>