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
class AttachmentUploadAsset extends AssetBundle
{
    public $sourcePath = '@hass/attachment/misc';
    public $css = [
        'attachment-upload.css',
    ];
    public $js = [
        'attachment-upload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'hass\base\misc\blueimpFileupload\BlueimpFileuploadAsset',
        'hass\backend\assets\AdminAsset'
    ];
}

?>