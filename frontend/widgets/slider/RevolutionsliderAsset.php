<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace frontend\widgets\slider;
use yii\web\AssetBundle;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


class RevolutionsliderAsset extends AssetBundle
{
    public $sourcePath = "@frontend/widgets/slider/assets";

    public $css = [
        "js/revolution-slider/css/settings.css",
        "css/widget.css"
    ];

    public $js = [        
        "js/revolution-slider/js/jquery.themepunch.plugins.min.js",
        "js/revolution-slider/js/jquery.themepunch.revolution.min.js",
        'js/revolution.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}