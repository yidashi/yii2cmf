<?php
namespace common\widgets\tag;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

class TagsInput extends Select2
{

    public  $options =  ['placeholder' => '选择一个标签 ...', 'multiple' => true];

    public $pluginOptions =  [
        'tags' => true,
        'maximumInputLength' => 10
    ];

    public $data;

    public $ajaxUrl = ['/tag/search'];

    public $toggleAllSettings= [
        'selectLabel' => '',
        'unselectLabel' => '',
        'selectOptions' => ['class' => 'text-success'],
        'unselectOptions' => ['class' => 'text-danger'],
    ];
    public function init()
    {
        parent::init();
        $this->pluginOptions['ajax'] = [
            'url' => Url::to($this->ajaxUrl),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ];
    }
}

?>