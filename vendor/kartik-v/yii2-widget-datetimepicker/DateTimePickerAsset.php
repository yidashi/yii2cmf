<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-datetimepicker
 * @version 1.4.2
 */

namespace kartik\datetime;

/**
 * Asset bundle for DateTimePicker Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DateTimePickerAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/bootstrap-datetimepicker', 'css/datetimepicker-kv']);
        $this->setupAssets('js', ['js/bootstrap-datetimepicker']);
        parent::init();
    }
}