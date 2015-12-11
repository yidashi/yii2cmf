<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:15
 */
namespace common\widgets\markdown;
use yii;
use yii\helpers\Html;
class Markdown extends yii\base\Widget{
    public $model;
    public $attribute;
    public $name;
    public $value;
    public $language;
    public $options;
    public function init(){
        $this->options['id']='markdown-textarea';
        if(!$this->language){
            $this->language='en';
        }
    }
    public function run(){
        MarkdownAsset::register($this->view);
        $this->view->registerJs('
            var markdown=$("#markdown-textarea").markdown({autofocus:false,language:"zh"});
        ');
        if(isset($this->model) && isset($this->attribute)){
            return Html::activeTextarea($this->model,$this->attribute,$this->options);
        }elseif(isset($this->name) && isset($this->value)){
            return Html::textarea($this->name,$this->value,$this->options);
        }
    }
}