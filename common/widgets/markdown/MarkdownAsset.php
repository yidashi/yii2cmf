<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18
 */
namespace common\widgets\markdown;
use yii\web\AssetBundle;
class MarkdownAsset extends AssetBundle{
    public $sourcePath='@npm/bootstrap-markdown';
    public $css = [
        'css/bootstrap-markdown.min.css',
    ];
    public $js = [
        'js/bootstrap-markdown.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\markdown\Markdown2HtmlAsset',
    ];
}