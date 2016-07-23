<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 下午12:06
 */

namespace common\widgets\city;


use yii\web\AssetBundle;

class CityAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/city/assets';

    public $js = [
        'city.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}