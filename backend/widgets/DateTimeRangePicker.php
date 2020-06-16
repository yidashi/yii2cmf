<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/5/21
 * Time: 10:56 上午
 */

namespace backend\widgets;

use dosamigos\datepicker\DatePickerLanguageAsset;
use dosamigos\datepicker\DatePickerTrait;
use dosamigos\datepicker\DateRangePickerAsset;
use kartik\datetime\DateTimePickerAsset;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class DateTimeRangePicker extends InputWidget
{
    use DatePickerTrait;

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
    public $labelTo = 'to';
    /**
     * @var \yii\widgets\ActiveForm useful for client validation of attributeTo
     */
    public $form;
    /**
     * @var string the template to render. Used internally.
     */
    protected $_template = '{inputFrom}<span class="input-group-addon">{labelTo}</span>{inputTo}';


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
        if ($this->size) {
            Html::addCssClass($this->options, 'input-' . $this->size);
            Html::addCssClass($this->optionsTo, 'input-' . $this->size);
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
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
            Html::addCssClass($this->options, 'datepicker-from');
            Html::addCssClass($this->optionsTo, 'datepicker-to');
            $inputFrom = $this->form->field(
                $this->model,
                $this->attribute,
                [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'input-group datepicker-range'],
                ]
            )->textInput($this->options);
            $inputTo = $this->form->field(
                $this->model,
                $this->attributeTo,
                [
                    'template' => '{input}{error}',
                    'options' => ['class' => 'input-group datepicker-range'],
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
        echo Html::tag(
            'div',
            strtr(
                $this->_template,
                ['{inputFrom}' => $inputFrom, '{labelTo}' => $this->labelTo, '{inputTo}' => $inputTo]
            ),
            $this->containerOptions
        );

        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as DateRangePicker
     */
    public function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        // @codeCoverageIgnoreStart
        if ($this->language !== null) {
            $this->clientOptions['language'] = $this->language;
            DateTimePickerAsset::register($view)->js[] = 'js/locales/bootstrap-datetimepicker.' . $this->language . '.js';
        } else {
            DateRangePickerAsset::register($view);
        }
        // @codeCoverageIgnoreEnd

        $id = $this->options['id'];
        $selector = ";jQuery('#$id').parent().find('input')";
        if ($this->form && $this->hasModel()) {
            // @codeCoverageIgnoreStart
            $selector .= '.parent()';
            $class = "field-" . Html::getInputId($this->model, $this->attribute);
            $js[] = "$selector.closest('.$class').removeClass('$class');";
            // @codeCoverageIgnoreEnd
        }

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';

        $js[] = "$selector.datetimepicker($options);";

        // @codeCoverageIgnoreStart
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$selector.on('$event', $handler);";
            }
        }
//        p($js);
        // @codeCoverageIgnoreEnd
        $view->registerJs(implode("\n", $js));
    }
}
