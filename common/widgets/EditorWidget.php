<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午1:57
 */

namespace common\widgets;


use common\widgets\editormd\Editormd;
use vova07\imperavi\Widget;
use yii\base\InvalidParamException;
use yii\widgets\InputWidget;
use yii\helpers\Url;

class EditorWidget extends InputWidget
{

    public $isMarkdown;

    public $typeEnum = ['redactor', 'markdown'];
    /**
     * @var string 编辑器类型
     */
    public $type;

    public $inputOptions = ['rows' => 10];

    public function init()
    {
        if (isset($this->isMarkdown)) {
            if ($this->isMarkdown) {
                $this->type = 'markdown';
            } else {
                $this->type = 'redactor';
            }
        }
        if ($this->type === null) {
            $this->type = 'redactor';
        }
        if(!in_array($this->type, $this->typeEnum)) {
            throw new InvalidParamException('编辑器类型不存在');
        }
        $this->options = array_merge($this->inputOptions, $this->options);
    }

    public function run()
    {
        return call_user_func([$this, $this->type]);
    }
    public function markdown()
    {
        if ($this->hasModel()) {
            return Editormd::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'options' => $this->options
            ]);
        } else {
            return Editormd::widget([
                'name' => $this->name,
                'value' => $this->value,
                'options' => $this->options
            ]);
        }
    }
    public function redactor()
    {
        $defaultOptions = [
            'lang' => 'zh_cn',
            'minHeight' => 200,
            'imageUpload' => Url::to(['/attachment/upload/redactor-image-upload']),
            'imageManagerJson' => Url::to(['/attachment/upload/redactor-images-get']),
            'fileManagerJson' => Url::to(['/attachment/upload/redactor-files-get']),
            'fileUpload' => Url::to(['/attachment/upload/redactor-file-upload']),
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'filemanager'
            ]
        ];
        $options = array_merge($defaultOptions, $this->options);
        if ($this->hasModel()) {
            return Widget::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'settings' => $options
            ]);
        } else {
            return Widget::widget([
                'name' => $this->name,
                'value' => $this->value,
                'settings' => $options
            ]);
        }
    }
}