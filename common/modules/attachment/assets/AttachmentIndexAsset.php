<?php

namespace common\modules\attachment\assets;

use yii\web\AssetBundle;

class AttachmentIndexAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/attachment/static';
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