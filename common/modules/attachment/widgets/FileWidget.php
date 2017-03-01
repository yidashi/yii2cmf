<?php

namespace common\modules\attachment\widgets;

use common\modules\attachment\models\Attachment;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;

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

    protected function formartAttachment($attachment)
    {
        if (is_string($attachment) && !empty($attachment)) {
            $model = Attachment::find()->where(['url' => $attachment])->one();
            return [
                "url"=>$attachment,
                "path"=>$attachment,
                'filename' => $model ? $model->name : $attachment
            ];
        } else if (is_array($attachment)) {
            return $attachment;
        }

        return null;
    }
}