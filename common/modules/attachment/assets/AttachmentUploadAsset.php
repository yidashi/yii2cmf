<?php
namespace common\modules\attachment\assets;

use yii\web\AssetBundle;

class AttachmentUploadAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/attachment/static';
    public $css = [
        'attachment-upload.css',
    ];
    public $js = [
        'attachment-upload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\modules\attachment\widgets\blueimpFileupload\BlueimpFileuploadAsset',
        'backend\assets\AppAsset'
    ];
}

?>