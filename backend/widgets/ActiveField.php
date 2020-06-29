<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/2/11
 * Time: 下午9:43
 */

namespace backend\widgets;

use common\modules\attachment\widgets\SingleWidget;
use dosamigos\datepicker\DateRangePicker;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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

    public function select2($items, $config = [])
    {
        $placeholder = ArrayHelper::remove($config, 'prompt', '请选择');
        $config['data'] = $items;
        $config['placeholder'] = $placeholder;
        return $this->widget(Select2Widget::className(), $config);
    }

    public function multiple($items, $config = [])
    {
        $config['multiple'] = true;
        return $this->select2($items, $config);
    }

    public function image($config = [])
    {
        return $this->widget(SingleWidget::className(), $config);
    }

    public function file($config = [])
    {
        $config = ArrayHelper::merge($config, ['onlyImage' => false]);
        return $this->widget(SingleWidget::className(), $config);
    }

    public function date($config = [])
    {
        return $this->widget(DatePicker::className(), $config);
    }

    public function datetime($config = [])
    {
        return $this->widget(DateTimePicker::className(), $config);
    }

    public function daterange($attributeTo, $config = [])
    {
        $config['attributeTo'] = $attributeTo;
        $config['options']['autocomplete'] = 'off';
        $config['optionsTo'] = $config['options'];
        return $this->widget(DateRangePicker::className(), $config);
    }

    public function datetimerange($attributeTo, $config = [])
    {
        $config['attributeTo'] = $attributeTo;
        $config['options']['autocomplete'] = 'off';
        $config['optionsTo'] = $config['options'];
        return $this->widget(DateTimeRangePicker::className(), $config);
    }

    public function monthrange($attributeTo, $config = [])
    {
        $config['attributeTo'] = $attributeTo;
        $config['options']['autocomplete'] = 'off';
        $config['optionsTo'] = $config['options'];
        $config['clientOptions']['startView'] = 1;
        $config['clientOptions']['minViewMode'] = 1;
        $config['clientOptions']['format'] = 'yyyy-mm';
        $config['clientOptions']['autoclose'] = true;
        return $this->widget(DateRangePicker::className(), $config);
    }

    public function range($attributeTo, $config = [])
    {
        $config['attributeTo'] = $attributeTo;
        $config['options']['autocomplete'] = 'off';
        $config['optionsTo'] = $config['options'];
        return $this->widget(RangeWidget::class, $config);
    }

    public function city($cityAttribute, $config = [])
    {
        $config['attributeTo'] = $cityAttribute;
        return $this->widget(CityWidget::class, $config);
    }

    public function bool()
    {
        return parent::inline()->radioList(['否', '是']);
    }

    public function depdrop($data, $ajaxUrl, $depends, $options = [])
    {
        $placeholder = ArrayHelper::remove($options, 'prompt', '请选择');
        $options['prompt'] = $placeholder;
        return $this->widget(DepDrop::class, [
            'data' => $data,
            'value' => $this->model->getAttribute($this->attribute),
            'type' => 2,
            'options' => $options,
            'pluginOptions' => [
                'depends' => $depends,
                'placeholder' => $placeholder,
                'url' => Url::to($ajaxUrl),
            ]
        ]);
    }
}