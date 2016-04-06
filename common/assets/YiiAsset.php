<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/6
 * Time: 下午3:01
 */

namespace common\assets;


use yii\web\AssetBundle;

class YiiAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';
    public $js = [
        'yii.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}