<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18.
 */
namespace common\widgets\tag;

use yii\web\AssetBundle;

class TagAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/tag/assets';
    public $css = [
        'jquery.tagsinput.min.css',
    ];
    public $js = [
        'jquery.tagsinput.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
