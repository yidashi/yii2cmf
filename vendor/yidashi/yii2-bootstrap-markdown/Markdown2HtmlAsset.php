<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:32
 */
namespace yidashi\markdown;
use yii\web\AssetBundle;
class Markdown2HtmlAsset extends AssetBundle{
    public $js = [
        'js/markdown.js',
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}