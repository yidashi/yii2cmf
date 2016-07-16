<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/2
 * Time: 下午12:00
 */

namespace frontend\widgets\highlight;


use yii\web\AssetBundle;

class HighLightAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/highlight/assets';
    public $css = [
        'highlight.css',
    ];
    public $js = [
        'highlight.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}