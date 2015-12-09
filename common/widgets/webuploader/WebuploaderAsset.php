<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18
 */
namespace common\widgets\webuploader;
use yii\web\AssetBundle;
class WebuploaderAsset extends AssetBundle{
    public $sourcePath='@common/widgets/webuploader/assets';
    public $css = [
        'webuploader.css',
    ];
    public $js = [
        'webuploader.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}