<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/1/13
 * Time: 下午3:04.
 */

namespace backend\widgets;

use kartik\select2\Select2;

class Select2Widget extends Select2
{
    public $width;

    public $theme = self::THEME_BOOTSTRAP;

    public $placeholder = '';

    public $multiple = false;

    public $toggleAllSettings = [
        'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> 全选',
        'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> 取消全选',
        'selectOptions' => ['class' => 'text-success'],
        'unselectOptions' => ['class' => 'text-danger'],
    ];

    public $pluginOptions = ['allowClear' => true];

    public function init()
    {
        parent::init();
//        if ($this->hasModel()) {
//            $this->placeholder = $this->model->getAttributeLabel($this->attribute);
//        }
        $this->options['placeholder'] = isset($this->options['placeholder']) ? $this->options['placeholder'] : $this->placeholder;
        $this->options['multiple'] = isset($this->options['multiple']) ? $this->options['multiple'] : $this->multiple;
        if (!empty($this->width)) {
            $this->pluginOptions['width'] = $this->width;
        }
    }
}
