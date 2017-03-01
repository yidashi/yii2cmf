<?php

namespace common\modules\attachment\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;

class SingleWidget extends MultipleWidget
{

    public $multiple = false;

    public $maxFileSize = 0;

    public $maxNumberOfFiles = 1;

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " single-media");
        parent::registerClientScript();
    }
}