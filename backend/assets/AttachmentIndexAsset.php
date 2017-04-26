<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AttachmentIndexAsset extends AssetBundle
{
    public $sourcePath = '@backend/static';
    public $css = [
        'attachment-index.css',
        'attachment-info.css'
    ];
    public $js = [
        'attachment-index.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}

?>