<?php

namespace common\widgets\upload;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;

class SingleWidget extends MultipleWidget
{

    public $multiple = false;

    public $url = [
        '/upload/image-upload'
    ];

    public $maxFileSize = 0;

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " single-media upload-kit");

        ImageUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);
        $this->getView()->registerCss(".single-media .upload-kit-input {
    height: 150px;
    width: 100%;
}
.single-media .upload-kit-item  {
	margin:0;
}
.single-media .upload-kit-item.image > img {
    height: 100%;
    width: 100%;
    border-radius: 7px;
}

            ");
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').attachmentUpload({$options});");
    }
}