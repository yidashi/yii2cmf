<?php
namespace common\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

class ModalAsset extends AssetBundle
{
    public $sourcePath = '@common/static';
    public $js = [
        'modal.js'
    ];
    public $depends = [
        'common\assets\LayerAsset',
    ];
}
