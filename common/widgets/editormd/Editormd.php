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
        '/upload/md-image-upload',
        'fileparam' => 'editormd-image-file'
    ];

    public $mode = 'full';

    public function init()
    {
        parent::init();
        $this->options = array_merge([
            'height' => '300',
            'autoFocus' => false,
            'emoji' => true,
            'watch' => false,
            'placeholder' => '本编辑器支持Markdown编辑，左边编写，右边预览',
            'syncScrolling' => 'single',
            'imageUpload' => true,
            'imageFormats' => ["jpg", "jpeg", "gif", "png", "bmp", "webp", "JPG", "JPEG", "GIF", "PNG", "BMP", "WEBP"],
            'imageUploadURL' => \yii\helpers\Url::to($this->imageUploadRoute)
        ], $this->options);

        if ($this->mode = 'mini') {
            $this->options['toolbarIcons'] = ["bold", "h1", "h2", "h3", "h4", "h5", "h6", "list-ul", "list-ol", "link", "image", "code-block"];
        }
    }

    public function run()
    {
        if ($this->hasModel()) {
            $this->name = empty($this->options['name']) ? Html::getInputName($this->model, $this->attribute) :
                $this->options['name'];
            $this->value = Html::getAttributeValue($this->model, $this->attribute);
        }
        echo Html::tag('div', '', $this->options);
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        $editormd = EditormdAsset::register($view);
        $id = $this->options['id'];
        $this->options['value'] = $this->value ? $this->value : '';
        $this->options['name'] = $this->name;
        $this->options['path'] = $editormd->baseUrl . '/lib/';
        $options = Json::encode($this->options);
        $js = 'var editor = editormd("' . $id . '", ' . $options . ');';
        $view->registerJs($js);
    }
}