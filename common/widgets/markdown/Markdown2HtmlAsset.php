<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:32
 */
namespace common\widgets\markdown;
use yii\web\AssetBundle;
class Markdown2HtmlAsset extends AssetBundle{
    public $sourcePath='@npm/markdown';
    public $css = [
    ];
    public $js = [
        'lib/markdown.js',
    ];
    public $depends = [
    ];
}