<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:15
 */
namespace yidashi\markdown;
use yii;
use yii\helpers\Html;
class Markdown extends yii\widgets\InputWidget{
    public $language;
    public function init(){
        $this->options['id']='markdown-textarea';
        if(!$this->language){
            $this->language='zh';
        }
        parent::init();
    }
    public function run(){
        MarkdownAsset::register($this->view)->js[] = 'js/locale/bootstrap-markdown.' . $this->language . '.js';
        $this->view->registerJs('
            var markdown=$("#markdown-textarea").markdown({autofocus:false,language:"' . $this->language . '"});
        ');
        if($this->hasModel()){
            return Html::activeTextarea($this->model,$this->attribute,$this->options);
        }else{
            return Html::textarea($this->name,$this->value,$this->options);
        }
    }
}