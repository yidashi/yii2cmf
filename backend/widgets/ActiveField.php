<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/2/11
 * Time: 下午9:43
 */

namespace backend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActiveField extends \yii\bootstrap\ActiveField
{
    //重写horizontal布局下模板
    protected function createLayoutConfig($instanceConfig)
    {
        $config = [
            'hintOptions' => [
                'tag' => 'p',
                'class' => 'help-block',
            ],
            'errorOptions' => [
                'tag' => 'p',
                'class' => 'help-block help-block-error',
            ],
            'inputOptions' => [
                'class' => 'form-control',
            ],
        ];

        $layout = $instanceConfig['form']->layout;

        if ($layout === 'horizontal') {
            $config['template'] = "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}";
            $cssClasses = array_merge([
                'offset' => 'col-sm-offset-3',
                'label' => 'col-sm-2',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => 'horizontal-form-hint',
            ], $this->horizontalCssClasses);
            if (isset($instanceConfig['horizontalCssClasses'])) {
                $cssClasses = ArrayHelper::merge($cssClasses, $instanceConfig['horizontalCssClasses']);
            }
            $config['horizontalCssClasses'] = $cssClasses;
            $config['wrapperOptions'] = ['class' => $cssClasses['wrapper']];
            $config['labelOptions'] = ['class' => 'control-label ' . $cssClasses['label']];
            $config['errorOptions']['class'] = 'help-block help-block-error ' . $cssClasses['error'];
            $config['hintOptions']['class'] = $cssClasses['hint'];
        } elseif ($layout === 'inline') {
            $config['labelOptions'] = ['class' => 'sr-only'];
            $config['enableError'] = false;
        }

        return $config;
    }

    public function suffix($suffix = '', $suffixType = 'addon', $size = '')
    {
        if ($suffixType == 'button') {
            $suffixType = 'btn';
        }
        $size = !empty($size) ? "input-group-{$size} " : '';
        $this->inputOptions = ['class' => 'form-control', 'autocomplete' => 'off'];
        $this->template = str_replace('{input}', "<div class=\"input-group $size\">{input}\n<div class=\"input-group-" . $suffixType . "\">" . $suffix . "</div></div>", $this->template);
        return $this;
    }

    public function prefix($prefix = '', $prefixType = 'addon', $size = '')
    {
        $size = !empty($size) ? "input-group-{$size} " : '';
        $this->inputOptions = ['class' => 'form-control', 'autocomplete' => 'off'];
        $this->template = str_replace('{input}', "<div class=\"input-group $size\"><div class=\"input-group-" . $prefixType . "\">" . $prefix . "</div>\n{input}</div>", $this->template);
        return $this;
    }

    public function boolean($options = [], $enclosedByLabel = true)
    {
        if ($enclosedByLabel) {
            $this->parts['{input}'] = Html::activeBoolean($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = Html::activeBoolean($this->model, $this->attribute, $options);
        }
        $this->adjustLabelFor($options);

        return $this;
    }
    public function dropDownList($items, $options = [])
    {
        $options['prompt'] = ArrayHelper::remove($options, 'prompt', '请选择');
        return parent::dropDownList($items, $options);
    }

    public function textarea($options = [])
    {
        $options['rows'] = ArrayHelper::remove($options, 'rows', 5);
        return parent::textarea($options);
    }

    public function textInput($options = [])
    {
        $options['maxlength'] = true;
        return parent::textInput($options);
    }

}