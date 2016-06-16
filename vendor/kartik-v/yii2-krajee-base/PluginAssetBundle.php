<?php

/**
 * @package   yii2-krajee-base
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   1.8.5
 */

namespace kartik\base;

/**
 * Base asset bundle for Krajee extensions (including bootstrap plugins)
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.6.0
 */
class PluginAssetBundle extends AssetBundle
{
    /**
     * @inheritdoc
     */
     public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
