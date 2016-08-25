<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/15
 * Time: 上午11:34
 */

namespace common\widgets\dynamicInput;


use common\widgets\EditorWidget;
use common\widgets\upload\FileWidget;
use common\widgets\upload\SingleWidget;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class DynamicInputWidget extends InputWidget
{
    /**
     * @var array 支持的类型集合
     */
    public $types = [
        'text',
        'array',
        'password',
        'textarea',
        'select',
        'checkbox',
        'radio',
        'image',
        'editor',
        'date',
        'datetime',
        'file'
    ];
    public $type;
    public $data;
    public $inputOptions = ['class' => 'form-control'];
    public function init()
    {
        parent::init();
        if (!in_array($this->type, $this->types)) {
            throw new InvalidParamException('不支持的类型');
        }
        $this->data = $this->parseExtra($this->data);
    }

    public function run()
    {

        if($this->hasModel()) {
            return $this->parseActive();
        } else {
            return $this->parse();
        }
    }
    private  function parse()
    {
        switch ($this->type) {
            case 'text': // 文本框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::textInput($this->name, $this->value, $options);
                break;
            case 'password': // 密码框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::passwordInput($this->name, $this->value, $options);
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
                return SingleWidget::widget(['name' => $this->name, 'value' => $this->value]);
                break;
            case 'file': // 文件
                return FileWidget::widget(['name' => $this->name, 'value' => $this->value]);
                break;
            case 'editor': // 编辑器
                return EditorWidget::widget(['name' => $this->name, 'value' => $this->value]);
                break;
            case 'date': // 日期
                return DatePicker::widget([
                    'name' => $this->name,
                    'value' => $this->value,
                    'type' => 2,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d']
                ]);
                break;
            case 'datetime': // 时间
                return DateTimePicker::widget([
                    'name' => $this->name,
                    'value' => $this->value,
                    'type' => 2,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d H:i:s']
                ]);
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
            case 'password': // 密码框
                $options = array_merge($this->inputOptions, $this->options);
                return Html::activePasswordInput($this->model, $this->attribute, $options);
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
                return SingleWidget::widget(['model' => $this->model, 'attribute' => $this->attribute]);
                break;
            case 'file': // 文件
                return FileWidget::widget(['model' => $this->model, 'attribute' => $this->attribute]);
                break;
            case 'editor': // 编辑器
                return EditorWidget::widget(['model' => $this->model, 'attribute' => $this->attribute]);
                break;
            case 'date': // 日期
                return DatePicker::widget([
                    'model' => $this->model,
                    'attribute' => $this->attribute,
                    'type' => 2,
                    'convertFormat' => true,
                    'pluginOptions' => ['format' => 'php:Y-m-d']
                ]);
                break;
            case 'datetime': // 时间
                return DateTimePicker::widget([
                        'model' => $this->model,
                        'attribute' => $this->attribute,
                        'type' => 2,
                        'convertFormat' => true,
                        'pluginOptions' => ['format' => 'php:Y-m-d H:i:s']
                    ]);
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
        foreach (explode("\r\n", $value) as $val) {
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