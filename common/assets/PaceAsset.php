<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/26
 * Time: 下午2:08
 */

namespace common\assets;


use yii\web\AssetBundle;

class PaceAsset extends AssetBundle
{
    public $sourcePath = '@bower/pace';

    public $js = [
        'pace.js'
    ];

    public $css = [
        'themes/white/pace-theme-minimal.css'
    ];
}