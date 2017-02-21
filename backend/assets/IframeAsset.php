<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

class IframeAsset extends AssetBundle
{
    public $sourcePath = '@backend/static';

    public $js = [
        'js/iframe.js',
    ];
}
