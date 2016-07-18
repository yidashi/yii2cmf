<?php

namespace common\widgets\upload;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;
use common\widgets\upload\AttachmentUploadAsset;

class FileWidget extends MultipleWidget
{

    public $multiple = false;


    public $url = [
        '/upload/file-upload'
    ];

    public $maxFileSize = 0;

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " upload-kit-input");

        FileUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);

        $this->getView()->registerJs("jQuery('#{$this->options['id']}').attachmentFileUpload({$options});");
    }
}