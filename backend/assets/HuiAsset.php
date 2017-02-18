<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

class HuiAsset extends AssetBundle
{
    public $sourcePath = '@backend/static';

    public $js = [
        'js/H-ui.admin.js',
    ];
}
