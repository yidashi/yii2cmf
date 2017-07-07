<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 下午2:08
 */

namespace common\assets;


use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@common/static';

    public $css = [
        'font-awesome/css/font-awesome.min.css'
    ];
}