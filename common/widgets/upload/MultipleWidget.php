<?php
namespace common\widgets\upload;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\InputWidget;

class MultipleWidget extends InputWidget
{


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
    public $maxNumberOfFiles = 1;

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

      public $deleteUrl = ["/upload/delete"];

    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->hasModel()) {
            $this->name = $this->name ? : Html::getInputName($this->model, $this->attribute);
            $value = Html::getAttributeValue($this->model, $this->attribute);
            $attachments = $this->multiple == true ? $value :[$value];
            $this->value = [];
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $value = $this->formartAttachment($attachment);
                    if ($value) {
                        $this->value[] = $value;
                    }
                }
            }

        }

        if (! array_key_exists('fileparam', $this->url)) {
            $this->url['fileparam'] = $this->name;//服务器需要通过这个判断是哪一个input name上传的
        }

        $this->clientOptions = ArrayHelper::merge($this->clientOptions, [
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

    protected function formartAttachment($attachment)
    {
        if (is_string($attachment) && !empty($attachment)) {
            return [
                "url"=>$attachment,
                "path"=>$attachment
            ];
        } else if (is_array($attachment)) {
            return $attachment;
        }

        return null;
    }



    /**
     *
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $content = Html::beginTag('div',$this->wrapperOptions);
        $content .= Html::fileInput($this->name, null, [
            'id' => $this->options['id'],
            'multiple' => $this->multiple
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

        ImageUploadAsset::register($this->getView());

        if ($this->sortable) {
            JuiAsset::register($this->getView());
        }

        $options = Json::encode($this->clientOptions);
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').attachmentUpload({$options});");
    }
}
