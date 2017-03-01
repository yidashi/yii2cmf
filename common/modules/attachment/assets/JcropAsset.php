<?php
namespace common\modules\attachment\assets;

use yii\web\AssetBundle;


class JcropAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/attachment/static';
    public $js = [
        'jquery.color.js',
        'Jcrop.js'
    ];

    public $css = [
        'Jcrop.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
