<?php
namespace common\modules\attachment\widgets\blueimpFileupload;

use yii\web\AssetBundle;

class BlueimpTmplAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-tmpl';

    public $js = [
        'js/tmpl.min.js'
    ];
}
