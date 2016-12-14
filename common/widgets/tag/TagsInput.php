<?php
namespace common\widgets\tag;

use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

class TagsInput extends Select2
{

    public  $options =  ['placeholder' => '标签 ...', 'multiple' => true];

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
            'delay' => 500,
            'minimumInputLength' => 2,
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ];
    }
}

?>