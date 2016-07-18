<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/17
 * Time: 下午11:46
 */

namespace frontend\themes\umifan\assets\fancybox;


use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__;
    }
    public $css = [
        'jquery.fancybox.css'
    ];

    public $js = [
        'jquery.fancybox.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}