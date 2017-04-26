<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/12/7 9:51
 * Description:
 */

namespace common\widgets\editormd;

use yii\web\AssetBundle;

class EditormdAsset extends AssetBundle
{
    public $sourcePath = '@bower/editor.md';

    public $js = [
        'editormd.min.js'
    ];

    public $css = [
        'css/editormd.css',
        'css/editormd.logo.css',
        'css/editormd.preview.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\FontAwesomeAsset'
    ];
}