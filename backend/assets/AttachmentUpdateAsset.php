<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\assets;
use yii\web\AssetBundle;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class AttachmentUpdateAsset extends AssetBundle
{
    public $sourcePath = '@hass/attachment/misc';
    public $css = [
        'attachment-update.css',
        'attachment-info.css'
    ];
    public $js = [
        'attachment-update.js',
    ];
    public $depends = [
        'hass\backend\assets\AdminAsset',
        'hass\base\misc\jcrop\JcropAsset'
    ];
}

?>