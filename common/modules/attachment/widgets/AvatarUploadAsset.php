<?php
namespace common\modules\attachment\widgets;

use yii\web\AssetBundle;

class AvatarUploadAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/attachment/widgets/static';
    public $css = [
        'avatar-upload.css',
    ];
    public $js = [
        'avatar-upload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\modules\attachment\widgets\blueimpFileupload\BlueimpFileuploadAsset',
        'common\modules\attachment\assets\JcropAsset'
    ];
}