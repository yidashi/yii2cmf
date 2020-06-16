<?php
namespace backend\assets;


class HtmlSortableAsset extends \yii\web\AssetBundle
{
    public $sourcePath = null;
    public $baseUrl = '@web/static';
    public $js = [
        'js/html.sortable.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}