<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/15
 * Time: 上午11:34
 */

namespace common\widgets\dynamicInput;


use common\modules\attachment\widgets\MultipleWidget;
use common\modules\city\widgets\CityWidget;
use common\widgets\EditorWidget;
use common\modules\attachment\widgets\SingleWidget;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class DynamicInputWidget extends InputWidget
{
    /**
     * @var array 支持的类型集合
     */
    public $types = [
        'text',
        'prefixText',
        'suffixText',
        'array',
        'boolean',
        'password',
        'textarea',
        'select',
        'checkbox',
        'radio',
        'image',
        'images',
        'editor',
        'date',
        'datetime',
        'file',
        'files',
        'city',
    ];
    public $type;
    public $data;
    public $inputOptions = ['class' => 'form-control'];
    public $widgetOptions = [];

    public function init()
    {
        parent::init();
        if (!in_array($this->type, $this->types)) {
            throw new InvalidParamException('不支持的类型');
        }
        $this->data = $this->parseExtra($this->data);
        if (is_string($this->data)) {
            $this->data = config($this->data);
        }
        if (empty($this->widgetOptions)) {
            $this->widgetOptions = ArrayHelper::remove($this->options, 'widgetOptions', []);
        }
    }

    public function run()
    {

        if ($this->hasModel()) {
            return $this->parseActive();
        } else {
            return $this->parse();
        }
    }

    private function parse()
    {
        switch ($this->type) {
            case 'text': // 文本框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::textInput($this->name, $this->value, $options);
                break;
            case 'prefixText': // 前缀文本框
                $options = array_merge($this->inputOptions, $this->options);
                $prefix = ArrayHelper::remove($options, 'prefix');
                $prefixType = ArrayHelper::remove($options, 'prefixType', 'addon');
                return '<div class="input-group">' . Html::tag('div', $prefix, ['class' => 'input-group-' . $prefixType]) . Html::textInput($this->name, $this->value, $options) . '</div>';
                break;
            case 'suffixText': // 后缀文本框
                $options = array_merge($this->inputOptions, $this->options);
                $suffix = ArrayHelper::remove($options, 'suffix');
                $suffixType = ArrayHelper::remove($options, 'suffixType', 'addon');
                return '<div class="input-group">' . Html::textInput($this->name, $this->value, $options) . Html::tag('div', $suffix, ['class' => 'input-group-' . $suffixType]) . '</div>';
                break;
            case 'password': // 密码框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::passwordInput($this->name, $this->value, $options);
                break;
            case 'boolean': // 布尔
                return Html::boolean($this->name, $this->value, $this->options);
                break;
            case 'array': // 数组
                $options = array_merge($this->inputOptions, ['rows' => 5], $this->options);
                return Html::textarea($this->name, $this->value, $options);
                break;
            case 'textarea': // 多行文本框
                $options = array_merge($this->inputOptions, ['rows' => 5], $this->options);
                return Html::textarea($this->name, $this->value, $options);
                break;
            case 'select': // 下拉
                $options = array_merge($this->inputOptions, $this->options);
                return Html::dropDownList($this->name, $this->value, $this->data, $options);
                break;
            case 'checkbox': // 多选
                return Html::checkboxList($this->name, $this->value, $this->data, $this->options);
                break;
            case 'radio': // 单选
                return Html::radioList($this->name, $this->value, $this->data, $this->options);
                break;
            case 'image': // 图片
                return SingleWidget::widget(ArrayHelper::merge(['name' => $this->name, 'value' => $this->value, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'images': // 图片
                return MultipleWidget::widget(ArrayHelper::merge(['name' => $this->name, 'value' => $this->value, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'file': // 文件
                return SingleWidget::widget(ArrayHelper::merge(['name' => $this->name, 'value' => $this->value, 'onlyImage' => false, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'files': // 文件
                return MultipleWidget::widget(ArrayHelper::merge(['name' => $this->name, 'value' => $this->value, 'onlyImage' => false, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'editor': // 编辑器
                return EditorWidget::widget(ArrayHelper::merge([
                    'name' => $this->name,
                    'value' => $this->value
                ], $this->widgetOptions));
                break;
            case 'date': // 日期
                return DatePicker::widget(ArrayHelper::merge([
                    'name' => $this->name,
                    'value' => $this->value,
                    'type' => 3,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d', 'autoclose' => true],
                ], $this->widgetOptions));
                break;
            case 'datetime': // 时间
                return DateTimePicker::widget(ArrayHelper::merge([
                    'name' => $this->name,
                    'value' => $this->value,
                    'type' => 3,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d H:i:s', 'autoclose' => true]
                ], $this->widgetOptions));
                break;
            case 'city': //城市联动
                return CityWidget::widget(ArrayHelper::merge([
                    'name' => $this->name,
                    'value' => $this->value,
                ], $this->widgetOptions));
                break;
        }
    }

    private function parseActive()
    {
        switch ($this->type) {
            case 'text': // 文本框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::activeTextInput($this->model, $this->attribute, $options);
                break;
            case 'prefixText': // 前缀文本框
                $options = array_merge($this->inputOptions, $this->options);
                $prefix = ArrayHelper::remove($options, 'prefix');
                $prefixType = ArrayHelper::remove($options, 'prefixType', 'addon');
                return '<div class="input-group">' . Html::tag('div', $prefix, ['class' => 'input-group-' . $prefixType]) . Html::activeTextInput($this->model, $this->attribute, $options) . '</div>';
                break;
            case 'suffixText': // 后缀文本框
                $options = array_merge($this->inputOptions, $this->options);
                $suffix = ArrayHelper::remove($options, 'suffix');
                $suffixType = ArrayHelper::remove($options, 'suffixType', 'addon');
                return '<div class="input-group">' . Html::activeTextInput($this->model, $this->attribute, $options) . Html::tag('div', $suffix, ['class' => 'input-group-' . $suffixType]) . '</div>';
                break;
            case 'password': // 密码框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::activePasswordInput($this->model, $this->attribute, $options);
                break;
            case 'boolean': // 布尔
                return Html::activeBoolean($this->model, $this->attribute, ArrayHelper::merge($this->options, ['label' => false]));
                break;
            case 'array': // 数组
                $options = array_merge($this->inputOptions, ['rows' => 5], $this->options);
                return Html::activeTextarea($this->model, $this->attribute, $options);
                break;
            case 'textarea': // 多行文本框
                $options = array_merge($this->inputOptions, ['rows' => 5], $this->options);
                return Html::activeTextarea($this->model, $this->attribute, $options);
                break;
            case 'select': // 下拉
                $options = array_merge($this->inputOptions, $this->options);
                return Html::activeDropDownList($this->model, $this->attribute, $this->data, $options);
                break;
            case 'checkbox': // 多选
                return Html::activeCheckboxList($this->model, $this->attribute, $this->data, $this->options);
                break;
            case 'radio': // 单选
                return Html::activeRadioList($this->model, $this->attribute, $this->data, $this->options);
                break;
            case 'image': // 图片
                return SingleWidget::widget(ArrayHelper::merge(['model' => $this->model, 'attribute' => $this->attribute, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'images': // 图片
                return MultipleWidget::widget(ArrayHelper::merge(['model' => $this->model, 'attribute' => $this->attribute, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'file': // 文件
                return SingleWidget::widget(ArrayHelper::merge(['model' => $this->model, 'attribute' => $this->attribute, 'onlyImage' => false, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'files': // 文件
                return MultipleWidget::widget(ArrayHelper::merge(['model' => $this->model, 'attribute' => $this->attribute, 'onlyImage' => false, 'onlyUrl' => true], $this->widgetOptions));
                break;
            case 'editor': // 编辑器
                return EditorWidget::widget(ArrayHelper::merge([
                    'model' => $this->model,
                    'attribute' => $this->attribute
                ], $this->widgetOptions));
                break;
            case 'date': // 日期
                return DatePicker::widget(ArrayHelper::merge([
                    'model' => $this->model,
                    'attribute' => $this->attribute,
                    'type' => 3,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d', 'autoclose' => true],
                ], $this->widgetOptions));
                break;
            case 'datetime': // 时间
                return DateTimePicker::widget(ArrayHelper::merge([
                    'model' => $this->model,
                    'attribute' => $this->attribute,
                    'type' => 3,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d H:i:s', 'autoclose' => true],
                ], $this->widgetOptions));
                break;
            case 'city': //城市联动
                return CityWidget::widget(ArrayHelper::merge([
                    'model' => $this->model,
                    'attribute' => $this->attribute,
                ], $this->widgetOptions));
                break;
        }
    }

    /**
     * 分析枚举类型.
     * @param $value string
     * @return array
     */
    public function parseExtra($value)
    {
        $return = [];
        if (is_array($value)) {
            return $value;
        }
        if (config()->has($value)) {
            return config($value);
        }
//        foreach (explode("\r\n", $value) as $val) {
        foreach (preg_split("/[\r\n]+/s", $value) as $val) {
            if (strpos($val, '=>') !== false) {
                list($k, $v) = explode('=>', $val);
                $return[$k] = $v;
            } else {
                $return[] = $val;
            }
        }
        return $return;
    }
}