<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/4/17
 * Time: 下午3:41
 */

namespace common\assets;


use yii\web\AssetBundle;

class SweetalertAsset extends AssetBundle
{
    public $sourcePath = '@common/static';

    public $css = [
        'sweetalert/sweetalert.css'
    ];

    public $js = [
        'sweetalert/sweetalert.min.js'
    ];
}