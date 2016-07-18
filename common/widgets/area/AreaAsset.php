<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 下午12:06
 */

namespace common\widgets\area;


use yii\web\AssetBundle;

class AreaAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/area/assets';

    public $js = [
        'area.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}