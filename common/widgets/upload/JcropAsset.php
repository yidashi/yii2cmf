<?php

namespace common\widgets\upload;

use yii\web\AssetBundle;


class JcropAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/upload/assets';
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
