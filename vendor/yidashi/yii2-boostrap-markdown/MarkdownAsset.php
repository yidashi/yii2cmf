<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18
 */
namespace yii\markdown;
use yii\web\AssetBundle;
class MarkdownAsset extends AssetBundle{
    public $language;
    public $sourcePath='@common/widgets/markdown/assets';
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