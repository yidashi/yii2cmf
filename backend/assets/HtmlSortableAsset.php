<?php
namespace backend\assets;


class HtmlSortableAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/static';
    public $js = [
        'js/html.sortable.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}