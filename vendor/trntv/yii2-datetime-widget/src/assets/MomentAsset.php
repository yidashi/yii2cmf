<?php
namespace trntv\yii\datetime\assets;

use yii\web\AssetBundle;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class MomentAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/moment';

    /**
     * @var array
     */
    public $js = [
        'min/moment-with-locales.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
