<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2019-07-22
 * Time: 17:14
 */

namespace backend\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class RangeWidget extends InputWidget
{
    /**
     * @var string the attribute name for date range (to Date)
     */
    public $attributeTo;
    /**
     * @var string the name for date range (to Date)
     */
    public $nameTo;
    /**
     * @var string the value for date range (to Date value)
     */
    public $valueTo;
    /**
     * @var array HTML attributes for the date to input
     */
    public $optionsTo;
    /**
     * @var string the label to. Defaults to 'to'.
     */
    public $labelTo = '至';
    /**
     * @var \yii\widgets\ActiveForm useful for client validation of attributeTo
     */
    public $form;
    /**
     * @var string the template to render. Used internally.
     */
    protected $_template = '{inputFrom}<span class="input-group-addon">{labelTo}</span>{inputTo}';

    public $containerOptions = [];

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ((!$this->hasModel() && $this->nameTo === null) || ($this->hasModel() && $this->attributeTo === null)) {
            // @codeCoverageIgnoreStart
            throw new InvalidConfigException("Either 'nameTo', or 'model' and 'attributeTo' properties must be specified.");
            // @codeCoverageIgnoreEnd
        }
        Html::addCssClass($this->containerOptions, 'input-group input-daterange');
        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->optionsTo, 'form-control');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->form) {
            $inputFrom = $this->form->field(
                $this->model,
                $this->attribute,
                [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'input-group'],
                ]
            )->textInput($this->options);
            $inputTo = $this->form->field(
                $this->model,
                $this->attributeTo,
                [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'input-group'],
                ]
            )->textInput($this->optionsTo);
        } else {
            $inputFrom = $this->hasModel()
                ? Html::activeTextInput($this->model, $this->attribute, $this->options)
                : Html::textInput($this->name, $this->value, $this->options);
            $inputTo = $this->hasModel()
                ? Html::activeTextInput($this->model, $this->attributeTo, $this->optionsTo)
                : Html::textInput($this->nameTo, $this->valueTo, $this->optionsTo);
        }
        echo Html::tag('div', strtr($this->_template, ['{inputFrom}' => $inputFrom, '{labelTo}' => $this->labelTo, '{inputTo}' => $inputTo]), $this->containerOptions);

        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as DateRangePicker
     */
    public function registerClientScript()
    {
    }
}
