<?php
namespace trntv\yii\datetime\assets;

use yii\web\AssetBundle;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class DateTimeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker';

    /**
     * @var array
     */
    public $css = [
        'build/css/bootstrap-datetimepicker.min.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'build/js/bootstrap-datetimepicker.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'trntv\yii\datetime\assets\MomentAsset'
    ];

}