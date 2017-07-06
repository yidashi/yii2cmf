<?php

namespace common\widgets\editor\ueditor;


use yii\web\AssetBundle;

class UEditorAsset extends AssetBundle
{
    public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/static';
    }
}