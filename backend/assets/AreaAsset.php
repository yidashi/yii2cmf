<?php
namespace backend\assets;

class AreaAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/static';
    public $css = [
        'css/area.css',
    ];
    public $js = [
        'js/area.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\HtmlSortableAsset'

    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
}
