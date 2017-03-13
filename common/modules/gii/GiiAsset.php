<?php

namespace gii;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by Gii.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GiiAsset extends AssetBundle
{
    public $sourcePath = '@gii/assets';
    public $css = [
        'main.css',
    ];
    public $depends = [
        'yii\gii\GiiAsset',
    ];
}
