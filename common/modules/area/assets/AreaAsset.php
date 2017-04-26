<?php
namespace common\modules\area\assets;

class AreaAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/modules/area/static';
    public $css = [
        'area.css',
    ];
    public $js = [
        'area.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'backend\assets\HtmlSortableAsset'

    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
}
