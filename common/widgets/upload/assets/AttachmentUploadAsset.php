<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace common\widgets\upload\assets;

use yii\web\AssetBundle;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class AttachmentUploadAsset extends AssetBundle
{

    public $sourcePath = '@common/widgets/upload/assets';

    public $css = [
        'attachment-upload.css'
    ];

    public $js = [
        'attachment-upload.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\upload\assets\blueimpFileupload\BlueimpFileuploadAsset'
    ];
}
