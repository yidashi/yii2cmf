<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/12/7 9:51
 * Description:
 */

namespace common\widgets\editormd;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class Editormd extends InputWidget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];
    /**
     * editor options
     */
    public $clientOptions = [];

    public $imageUploadRoute = [
        '/attachment/upload/md-image-upload',
        'fileparam' => 'editormd-image-file'
    ];

    public $mode = 'full';

    public function init()
    {
        parent::init();
        $this->clientOptions = array_merge([
            'height' => '500',
            'dialogLockScreen' => false,
            'autoFocus' => false,
//            'emoji' => true,
            'watch' => false,
            'placeholder' => '',
            'syncScrolling' => 'single',
            'imageUpload' => true,
            'imageFormats' => ["jpg", "jpeg", "gif", "png", "bmp", "webp", "JPG", "JPEG", "GIF", "PNG", "BMP", "WEBP"],
            'imageUploadURL' => \yii\helpers\Url::to($this->imageUploadRoute),
            'toolbarIcons' => [
                "bold", "del", "italic", "quote", "uppercase", "lowercase", "|",
                "h1", "h2", "h3", "h4", "h5", "h6", "|",
                "list-ul", "list-ol", "hr", "|",
                "link", "image", "code", "preformatted-text", "code-block", "|",
                "watch", "preview", "fullscreen", "|", "help"
            ],
            'onchange' => new JsExpression(<<<js
function () {
    $('#' + this.id).blur();
}
js
)
        ], $this->clientOptions);

        if ($this->mode == 'mini') {
            $this->clientOptions['toolbarIcons'] = ["bold", "list-ul", "list-ol", "link", "image", "code-block", "|", "help"];
            $this->clientOptions['height'] = '300';
        }
    }

    public function run()
    {
        echo Html::beginTag('div', ['id' => $this->getId()]);
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, ['id' => Html::getInputId($this->model, $this->attribute)]);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        echo Html::endTag('div');
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        $editormd = EditormdAsset::register($view);
        $this->clientOptions['path'] = $editormd->baseUrl . '/lib/';
        $clientOptions = Json::encode($this->clientOptions);
        $js = 'var editor = editormd("' . $this->getId() . '", ' . $clientOptions . ');';
        $view->registerJs($js);
    }
}