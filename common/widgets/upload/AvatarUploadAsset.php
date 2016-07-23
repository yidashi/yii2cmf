<?php
namespace common\widgets\upload;

use yii\web\AssetBundle;

class AvatarUploadAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/upload/assets';
    public $css = [
        'avatar-upload.css',
    ];
    public $js = [
        'avatar-upload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\upload\blueimpFileupload\BlueimpFileuploadAsset',
        'common\widgets\upload\JcropAsset'
    ];
}