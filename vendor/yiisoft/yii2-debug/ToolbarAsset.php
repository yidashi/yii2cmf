<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\debug;

use yii\web\AssetBundle;

/**
 * Debugger toolbar asset bundle
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @since 2.0.6
 */
class ToolbarAsset extends AssetBundle
{
    public $sourcePath = '@yii/debug/assets';
    public $css = [
        'toolbar.css',
    ];
    public $js = [
        'toolbar.js'
    ];
}
