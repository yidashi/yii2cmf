<?php
namespace common\assets;

use yii\web\AssetBundle;


class LayerAsset extends AssetBundle
{
    public $sourcePath = '@common/static';
    public $js = [
        'layer/layer.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
