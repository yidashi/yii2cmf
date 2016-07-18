<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/17
 * Time: 下午11:41
 */

namespace frontend\themes\umifan\assets;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__;
    }
    public $css = [
        'css/main.css',
        'css/app.css'
    ];

    public $js = [
        'js/isotope.js',
        'js/app.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\FontAwesomeAsset',
        'frontend\themes\umifan\assets\fancybox\FancyboxAsset'
    ];
}