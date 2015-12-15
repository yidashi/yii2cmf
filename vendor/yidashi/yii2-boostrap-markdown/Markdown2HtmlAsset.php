<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:32
 */
namespace yidashi\markdown;
use yii\web\AssetBundle;
class Markdown2HtmlAsset extends AssetBundle{
    public $sourcePath='@common/widgets/markdown/assets';
    public $css = [
    ];
    public $js = [
        'js/markdown.js',
    ];
    public $depends = [
    ];
}