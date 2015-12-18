<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18
 */
namespace yidashi\webuploader;
use yii\web\AssetBundle;
class WebuploaderAsset extends AssetBundle{
    public $css = [
        'webuploader.css',
    ];
    public $js = [
        'webuploader.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}