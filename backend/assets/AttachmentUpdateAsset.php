<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AttachmentUpdateAsset extends AssetBundle
{
    public $sourcePath = null;
    public $baseUrl = '@web/static';
    public $css = [
        'attachment-update.css',
        'attachment-info.css'
    ];
    public $js = [
        'attachment-update.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'common\widgets\upload\JcropAsset'
    ];
}

?>