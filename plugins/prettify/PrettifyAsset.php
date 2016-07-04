<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 下午12:00
 */

namespace plugins\prettify;


use yii\web\AssetBundle;

class PrettifyAsset extends AssetBundle
{
    public $sourcePath = '@plugins/prettify/assets';
    public $css = [
        'prettify.css',
    ];
    public $js = [
        'prettify.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}