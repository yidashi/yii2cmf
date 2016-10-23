<?php
namespace common\assets;

use yii\base\Exception;
use yii\web\AssetBundle;


class LayerAsset extends AssetBundle
{
    public $sourcePath = '@common/static/layer';
    public $js = [
        'layer.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
