<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:15
 */
namespace common\widgets\markdown;
use yii;
use yii\helpers\Html;
class Markdown extends yii\widgets\InputWidget{
    public $language;
    public function init(){
        $this->options['id']='markdown-textarea';
        if(!$this->language){
            $this->language='en';
        }
        parent::init();
    }
    public function run(){
        MarkdownAsset::register($this->view);
        $this->view->registerJs('
            var markdown=$("#markdown-textarea").markdown({autofocus:false,language:"zh"});
        ');
        if($this->hasModel()){
            return Html::activeTextarea($this->model,$this->attribute,$this->options);
        }else{
            return Html::textarea($this->name,$this->value,$this->options);
        }
    }
}