<?php
namespace common\modules\attachment\widgets;

use yii\base\Arrayable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\InputWidget;

class MultipleWidget extends InputWidget
{

    public $onlyImage = true;

    public $wrapperOptions;
    /**
     *
     * @var array
     */
    public $clientOptions = [];

/*
 * ----------------------------------------------
 * 客户端选项,构成$clientOptions
 * ----------------------------------------------
 */
    /**
     *
     * @var array 上传url地址
     */
    public $url = [];

    /**
     *  这里为了配合后台方便处理所有都是设为true,文件上传数目请控制好 $maxNumberOfFiles
     * @var bool
     */
    public $multiple = true;

    /**
     *
     * @var bool
     */
    public $sortable = false;

    /**
     *
     * @var int 允许上传的最大文件数目
     */
    public $maxNumberOfFiles = 10;

    /**
     *
     * @var int 允许上传文件最大限制
     */
    public $maxFileSize;

    /**
     *
     * @var string 允许上传的附件类型
     */
    public $acceptFileTypes;

    /*
     * ----------------------------------------------
     * 客户端选项,构成$clientOptions
     * ----------------------------------------------
     */

    public $deleteUrl = ["/attachment/upload/delete"];

    public $fileInputName;
    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->url)) {
            if ($this->onlyImage === false) {
                $this->url = $this->multiple ? ['/attachment/upload/files-upload'] : ['/attachment/upload/file-upload'];
//                $this->acceptFileTypes = 'image/png, image/jpg, image/jpeg, image/gif, image/bmp, application/x-zip-compressed';
            } else {
                $this->url = $this->multiple ? ['/attachment/upload/images-upload'] : ['/attachment/upload/image-upload'];
//                $this->acceptFileTypes = 'image/png, image/jpg, image/jpeg, image/gif, image/bmp';
            }
        }
        if ($this->hasModel()) {
            $this->name = $this->name ? : Html::getInputName($this->model, $this->attribute);
            $this->attribute = Html::getAttributeName($this->attribute);
            $value = $this->model->{$this->attribute};
            $attachments = $this->multiple == true ? $value :[$value];
            $this->value = [];
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $value = $this->formatAttachment($attachment);
                    if ($value) {
                        $this->value[] = $value;
                    }
                }
            }

        }
        $this->fileInputName = md5($this->name);
        if (! array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->fileInputName;//服务器需要通过这个判断是哪一个input name上传的
        }

        $this->clientOptions = ArrayHelper::merge($this->clientOptions, [
            'id' => $this->options['id'],
            'name'=> $this->name, //主要用于上传后返回的项目name
            'url' => Url::to($this->url),
            'multiple' => $this->multiple,
            'sortable' => $this->sortable,
            'maxNumberOfFiles' => $this->maxNumberOfFiles,
            'maxFileSize' => $this->maxFileSize,
            'acceptFileTypes' => $this->acceptFileTypes,
            'files' => $this->value?:[]
        ]);


    }

    protected function formatAttachment($attachment)
    {
        if (!empty($attachment) && is_string($attachment)) {
            return [
                'url' => $attachment,
                'path' => $attachment,
            ];
        } else if (is_array($attachment)) {
            return $attachment;
        } else if ($attachment instanceof Arrayable)
            return $attachment->toArray();
        return [];
    }



    /**
     *
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $content = Html::hiddenInput($this->name . ($this->multiple ? '[]' : ''), null);
        $content .= Html::beginTag('div',$this->wrapperOptions);
        $content .= Html::fileInput($this->fileInputName, null, [
            'id' => $this->fileInputName,
            'multiple' => $this->multiple,
            'accept' => $this->acceptFileTypes
        ]);
        $content .= Html::endTag('div');
        return $content;
    }

    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        Html::addCssClass($this->wrapperOptions, " upload-kit");

        AttachmentUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);
        $this->getView()->registerJs("jQuery('#{$this->fileInputName}').attachmentUpload({$options});");
    }
}
