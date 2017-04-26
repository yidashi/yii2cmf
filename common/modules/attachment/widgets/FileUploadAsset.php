<?php

namespace common\modules\attachment\widgets;

use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{

    public $sourcePath = '@common/modules/attachment/widgets/static';

    public $css = [
        'file-upload.css'
    ];

    public $js = [
        'file-upload.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\modules\attachment\widgets\blueimpFileupload\BlueimpFileuploadAsset'
    ];
}
