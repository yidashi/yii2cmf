<?php
namespace common\modules\attachment\assets;

use yii\web\AssetBundle;

class AttachmentUpdateAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/attachment/static';
    public $css = [
        'attachment-update.css',
        'attachment-info.css'
    ];
    public $js = [
        'attachment-update.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'common\modules\attachment\assets\JcropAsset'
    ];
}

?>