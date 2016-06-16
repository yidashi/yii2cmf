<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.3.9
 */

namespace kartik\date;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;
use kartik\base\InputWidget;
use kartik\field\FieldRangeAsset;

/**
 * DatePicker widget is a Yii2 wrapper for the Bootstrap DatePicker plugin. The plugin is a fork of Stefan Petre's
 * DatePicker (of eyecon.ro), with improvements by @eternicode.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://eternicode.github.io/bootstrap-datepicker/
 */
class DatePicker extends InputWidget
{
    const CALENDAR_ICON = '<i class="glyphicon glyphicon-calendar"></i>';
    const TYPE_INPUT = 1;
    const TYPE_COMPONENT_PREPEND = 2;
    const TYPE_COMPONENT_APPEND = 3;
    const TYPE_INLINE = 4;
    const TYPE_RANGE = 5;
    const TYPE_BUTTON = 6;

    /**
     * @var string the markup type of widget markup must be one of the TYPE constants. Defaults to
     *     [[TYPE_COMPONENT_PREPEND]]
     */
    public $type = self::TYPE_COMPONENT_PREPEND;

    /**
     * @var string The size of the input - 'lg', 'md', 'sm', 'xs'
     */
    public $size;

    /**
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage with ActiveForm. This property is
     *     especially useful for client validation of `attribute2` for [[TYPE_RANGE]] validation.
     */
    public $form;

    /**
     * @var array the HTML attributes for the button that is rendered for [[DatePicker::TYPE_BUTTON]]. Defaults to
     *     `['class'=>'btn btn-default']`. The following special options are recognized:
     * - 'label': string the button label. Defaults to `<i class="glyphicon glyphicon-calendar"></i>`
     */
    public $buttonOptions = [];

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @var string the layout template to display the buttons (applicable only  when `type` is one of
     *     TYPE_COMPONENT_PREPEND or TYPE_COMPONENT_APPEND or TYPE_RANGE). The following tags will be parsed and
     *     replaced for TYPE_COMPONENT_PREPEND or TYPE_COMPONENT_APPEND :
     * - `{picker}`: will be replaced with the date picker button (rendered as a bootstrap input group addon).
     * - `{remove}`: will be replaced with the date clear/remove button (rendered as a bootstrap input group addon).
     * - `{input}`: will be replaced with the HTML input markup that stores the date.
     * For TYPE_RANGE the following tags will be parsed and replaced:
     * - `{input1}`: will be replaced with the HTML input markup that stores the date for attribute1.
     * - `{separator}`: will be replaced with the input group addon for field range separator. The text for the
     *    separator is set via the `separator` property.
     * - `{input2}`: will be replaced with the HTML input markup that stores the date for attribute2.
     * The `layout` defaults to the following value if not set:
     * - `{picker}{remove}{input}` for TYPE_COMPONENT_PREPEND
     * - `{input}{remove}{picker}` for TYPE_COMPONENT_APPEND
     * - `{input1}{separator}{input2}` for TYPE_RANGE
     */
    public $layout;

    /**
     * @var mixed the calendar picker button configuration.
     * - if this is passed as a string, it will be displayed as is (will not be HTML encoded).
     * - if this is set to `false`, the picker button will not be displayed.
     * - if this is passed as an array (this is the DEFAULT) it will treat this as HTML attributes for the button (to
     *     be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - icon: string, the bootstrap glyphicon name/suffix. Defaults to 'calendar'.
     *   - title: string|bool, the title to be displayed on hover. Defaults to 'Select date & time'. To disable, set it
     *     to `false`.
     */
    public $pickerButton = [];

    /**
     * @var mixed the calendar remove button configuration - applicable only for type set to
     *     `DatePicker::TYPE_COMPONENT_PREPEND` or `DatePicker::TYPE_COMPONENT_APPEND`.
     * - if this is passed as a string, it will be displayed as is (will not be HTML encoded).
     * - if this is set to `false`, the remove button will not be displayed.
     * - if this is passed as an array (this is the DEFAULT) it will treat this as HTML attributes for the button (to
     *     be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - icon - string, the bootstrap glyphicon name/suffix. Defaults to 'remove'.
     *   - title - string, the title to be displayed on hover. Defaults to 'Clear field'. To disable, set it to
     *     `false`.
     */
    public $removeButton = [];

    /**
     * @var string the model attribute 2 if you are using [[TYPE_RANGE]] for markup.
     */
    public $attribute2;

    /**
     * @var string the name of input number 2 if you are using [[TYPE_RANGE]] for markup
     */
    public $name2;

    /**
     * @var string the name of value for input number 2 if you are using [[TYPE_RANGE]] for markup
     */
    public $value2 = null;

    /**
     * @var array the HTML attributes for the input number 2 tag. if you are using [[TYPE_RANGE]] for markup
     */
    public $options2 = [];

    /**
     * @var string the range input separator if you are using [[TYPE_RANGE]] for markup. Defaults to 'to'.
     */
    public $separator = 'to';

    /**
     * @var array the HTML options for the DatePicker container
     */
    private $_container = [];

    /**
     * @var bool whether a prepend or append addon exists
     */
    protected $_hasAddon = false;

    /**
     * @inheritdoc
     */
    public $pluginName = 'kvDatepicker';

    /**
     * @inheritdoc
     */
    protected $_msgCat = 'kvdate';

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $this->renderDatePicker();
    }

    /**
     * Renders the date picker widget
     */
    protected function renderDatePicker()
    {
        $this->validateConfig();
        $this->_hasAddon = $this->type == self::TYPE_COMPONENT_PREPEND || $this->type == self::TYPE_COMPONENT_APPEND;
        $s = DIRECTORY_SEPARATOR;
        $this->initI18N(__DIR__);
        $this->setLanguage('bootstrap-datepicker.', __DIR__ . "{$s}assets{$s}", null, '.min.js');
        $this->parseDateFormat('date');
        $this->_container['id'] = $this->options['id'] . '-' . $this->_msgCat;
        if ($this->type == self::TYPE_INLINE) {
            $this->_container['data-date'] = $this->value;
        }
        if (empty($this->layout)) {
            if ($this->type === self::TYPE_COMPONENT_PREPEND) {
                $this->layout = '{picker}{remove}{input}';
            } elseif ($this->type === self::TYPE_COMPONENT_APPEND) {
                $this->layout = '{input}{remove}{picker}';
            } elseif ($this->type === self::TYPE_RANGE) {
                $this->layout = '{input1}{separator}{input2}';
            }
        }
        Html::addCssClass($this->options, 'krajee-datepicker');
        $this->options['data-datepicker-source'] = $this->type === self::TYPE_INPUT ? $this->options['id'] :
            $this->_container['id'];
        $this->options['data-datepicker-type'] = $this->type;
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Raise an error exception
     *
     * @param string $msg
     *
     * @throws InvalidConfigException
     */
    protected static function err($msg = '')
    {
        throw new InvalidConfigException($msg);
    }

    /**
     * Validates widget configuration
     *
     * @throw InvalidConfigException
     */
    protected function validateConfig()
    {
        if ($this->type < 1 || $this->type > 6 || !is_int($this->type)) {
            static::err("Invalid value for the property 'type'. Must be an integer between 1 and 6.");
        }
        if ($this->type === self::TYPE_RANGE) {
            if ($this->attribute2 === null && $this->name2 === null) {
                static::err("Either 'name2' or 'attribute2' properties must be specified for a datepicker 'range' markup.");
            }
            if (!class_exists("\\kartik\\field\\FieldRangeAsset")) {
                static::err(
                    "The yii2-field-range extension is not installed and is a pre-requisite for a DatePicker " .
                    "RANGE type. To install this extension run this command on your console: \n\n" .
                    "php composer.phar require kartik-v/yii2-field-range \"*\""
                );
            }
        }
        if (!isset($this->form)) {
            return;
        }
        if (!$this->form instanceof ActiveForm) {
            static::err("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
        }
        if (!$this->hasModel()) {
            static::err("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
        if ($this->type === self::TYPE_RANGE && !isset($this->attribute2)) {
            static::err("The 'attribute2' property must be set for a 'range' type markup and a defined 'form' property.");
        }
    }

    /**
     * Renders the source input for the DatePicker plugin. Graceful fallback to a normal HTML  text input in case
     * JQuery is not supported by the browser
     *
     * @return string
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'form-control');
        if ($this->type == self::TYPE_INLINE) {
            if (empty($this->options['readonly'])) {
                $this->options['readonly'] = true;
            }
            $this->options['class'] .= ' input-sm text-center';
        }
        if (isset($this->form) && ($this->type !== self::TYPE_RANGE)) {
            $vars = call_user_func('get_object_vars', $this);
            unset($vars['form']);
            return $this->form->field($this->model, $this->attribute)->widget(self::classname(), $vars);
        }
        $input = $this->type == self::TYPE_BUTTON ? 'hiddenInput' : 'textInput';
        return $this->parseMarkup($this->getInput($input));
    }

    /**
     * Returns the addon to render
     *
     * @param array  $options the HTML attributes for the addon
     * @param string $type whether the addon is the picker or remove
     *
     * @return string
     */
    protected function renderAddon(&$options, $type = 'picker')
    {
        if ($options === false) {
            return '';
        }
        if (is_string($options)) {
            return $options;
        }
        $icon = ($type === 'picker') ? 'calendar' : 'remove';
        Html::addCssClass($options, 'input-group-addon kv-date-' . $icon);
        $icon = '<i class="glyphicon glyphicon-' . ArrayHelper::remove($options, 'icon', $icon) . '"></i>';
        $title = ArrayHelper::getValue($options, 'title', '');
        if ($title !== false && empty($title)) {
            $options['title'] = ($type === 'picker') ? Yii::t('kvdate', 'Select date') :
                Yii::t('kvdate', 'Clear field');
        }
        return Html::tag('span', $icon, $options);
    }

    /**
     * Parses the input to render based on markup type
     *
     * @param string $input
     *
     * @return string
     */
    protected function parseMarkup($input)
    {
        $css = $this->disabled ? ' disabled' : '';
        $size = isset($this->size) ? "input-{$this->size} " : '';
        switch ($this->type) {
            case self::TYPE_INPUT:
                Html::addCssClass($this->options, $size . $css);
                return $input;
            case self::TYPE_COMPONENT_PREPEND:
            case self::TYPE_COMPONENT_APPEND:
                $size = isset($this->size) ? "input-group-{$this->size} " : '';
                Html::addCssClass($this->_container, "input-group {$size}date");
                $out = strtr($this->layout, [
                    '{picker}' => $this->renderAddon($this->pickerButton),
                    '{remove}' => $this->renderAddon($this->removeButton, 'remove'),
                    '{input}' => $input
                ]);
                return Html::tag('div', $out, $this->_container);
            case self::TYPE_BUTTON:
                Html::addCssClass($this->_container, 'date' . $css);
                $label = ArrayHelper::remove($this->buttonOptions, 'label', self::CALENDAR_ICON);
                if (!isset($this->buttonOptions['disabled'])) {
                    $this->buttonOptions['disabled'] = $this->disabled;
                }
                if (empty($this->buttonOptions['class'])) {
                    $this->buttonOptions['class'] = 'btn btn-default';
                }
                $button = Html::button($label, $this->buttonOptions);
                Html::addCssStyle($this->_container, 'display:block');
                return Html::tag('span', "{$input}{$button}", $this->_container);
            case self::TYPE_RANGE:
                $size = isset($this->size) ? "input-group-{$this->size} " : '';
                Html::addCssClass($this->_container, "input-group {$size}input-daterange");
                $this->initDisability($this->options2);
                if (isset($this->form)) {
                    Html::addCssClass($this->options, 'form-control kv-field-from');
                    Html::addCssClass($this->options2, 'form-control kv-field-to');
                    $input = $this->form->field($this->model, $this->attribute, [
                        'template' => '{input}{error}',
                        'options' => ['class' => 'kv-container-from form-control'],
                    ])->textInput($this->options);
                    $input2 = $this->form->field($this->model, $this->attribute2, [
                        'template' => '{input}{error}',
                        'options' => ['class' => 'kv-container-to form-control'],
                    ])->textInput($this->options2);
                } else {
                    if (empty($this->options2['id'])) {
                        $this->options2['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute2) :
                            $this->getId() . '-2';
                    }
                    Html::addCssClass($this->options2, 'form-control');
                    $input2 = $this->hasModel() ?
                        Html::activeTextInput($this->model, $this->attribute2, $this->options2) :
                        Html::textInput($this->name2, $this->value2, $this->options2);
                }
                $out = strtr($this->layout, [
                    '{input1}' => $input,
                    '{separator}' => "<span class='input-group-addon kv-field-separator'>{$this->separator}</span>",
                    '{input2}' => $input2
                ]);
                return Html::tag('div', $out, $this->_container);
            case self::TYPE_INLINE:
                Html::addCssClass($this->options, $size . $css);
                return Html::tag('div', '', $this->_container) . $input;
            default:
                return '';
        }
    }

    /**
     * Registers the needed client assets
     *
     * @return void
     */
    public function registerAssets()
    {
        if ($this->disabled) {
            return;
        }
        $view = $this->getView();
        $view->registerJs('jQuery.fn.kvDatepicker.dates={};');
        if (!empty($this->_langFile)) {
            DatePickerAsset::register($view)->js[] = $this->_langFile;
        } else {
            DatePickerAsset::register($view);
        }
        $id = $this->options['id'];
        $input = "jQuery('#{$id}')";
        $el = "jQuery('#" . $this->options['data-datepicker-source'] . "')";
        $this->registerPlugin($this->pluginName, $el);
        if ($this->type === self::TYPE_INLINE) {
            $view->registerJs("{$el}.on('changeDate',function(e){{$input}.val(e.format()).trigger('change')});");
        }
        if ($this->_hasAddon && $this->removeButton !== false) {
            $view->registerJs("initDPRemove('{$id}');");
        }
        if ($this->_hasAddon) {
            $view->registerJs("initDPAddon('{$id}');");
        }
        if ($this->type === self::TYPE_RANGE) {
            FieldRangeAsset::register($view);
            $view->registerJs("initDPRemove('{$id}', true);");
        }
    }
}
