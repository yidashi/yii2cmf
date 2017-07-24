<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午1:57
 */

namespace common\widgets\editor;


use common\widgets\editor\editormd\Editormd;
use common\widgets\editor\ueditor\UEditor;
use vova07\imperavi\Widget;
use yii\base\InvalidParamException;
use yii\widgets\InputWidget;
use yii\helpers\Url;

class EditorWidget extends InputWidget
{

    public $isMarkdown;

    public $typeEnum = ['redactor', 'markdown', 'ueditor'];

    protected $defaultRichType = 'ueditor';

    protected $defaultMarkdownType = 'markdown';
    /**
     * @var string 编辑器类型
     */
    public $type;

    public $inputOptions = ['rows' => 10];

    public function init()
    {
        if ($this->type === null) {
            if (isset($this->isMarkdown)) {
                if ($this->isMarkdown) {
                    $this->type = $this->defaultMarkdownType;
                } else {
                    $this->type = $this->defaultRichType;
                }
            } else {
                $this->type = $this->defaultRichType;
            }
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


    protected function markdown()
    {
        if ($this->hasModel()) {
            return Editormd::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'imageUploadRoute' => [
                    '/upload/md-image-upload',
                    'fileparam' => 'editormd-image-file'
                ],
                'options' => $this->options
            ]);
        } else {
            return Editormd::widget([
                'name' => $this->name,
                'value' => $this->value,
                'imageUploadRoute' => [
                    '/attachment/upload/md-image-upload',
                    'fileparam' => 'editormd-image-file'
                ],
                'options' => $this->options
            ]);
        }
    }
    protected function redactor()
    {
        $defaultOptions = [
            'lang' => 'zh_cn',
            'minHeight' => 200,
            'imageUpload' => Url::to(['/upload/redactor-image-upload']),
            'imageManagerJson' => Url::to(['/upload/redactor-images-get']),
            'fileManagerJson' => Url::to(['/upload/redactor-files-get']),
            'fileUpload' => Url::to(['/upload/redactor-file-upload']),
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

    protected function ueditor()
    {
        $clientOptions = [
            //定制菜单
            'toolbars' => [
                [
                    'fullscreen', 'source', 'undo', 'redo', '|',
                    'fontsize', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                    'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', 'simpleupload', 'insertimage', '|',
                    'insertorderedlist', 'insertunorderedlist', 'link', 'forecolor', 'backcolor', '|',
                    'lineheight', '|',
                    'indent', '|'
                ],
            ]
        ];
        if ($this->hasModel()) {
            return UEditor::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'saveUrl' => ['/upload/ueditor'],
                'options' => $this->options,
                'clientOptions' => $clientOptions
            ]);
        } else {
            return UEditor::widget([
                'name' => $this->name,
                'value' => $this->value,
                'saveUrl' => ['/upload/ueditor'],
                'options' => $this->options,
                'clientOptions' => $clientOptions
            ]);
        }
    }
}