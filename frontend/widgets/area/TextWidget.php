<?php

namespace frontend\widgets\area;

use yii\base\Widget;

class TextWidget extends Widget
{
    public $model;


    public function run() {
        return $this->model->template;
    }
}