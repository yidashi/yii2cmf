<?php

namespace common\modules\area\widgets;

use yii\base\Widget;

class TextWidget extends Widget
{
    public $model;


    public function run() {
        return $this->model->template;
    }
}