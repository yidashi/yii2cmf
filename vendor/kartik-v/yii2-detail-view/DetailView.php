<?php

/**
 * @package   yii2-detail-view
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   1.7.4
 */

namespace kartik\detail;

use Yii;
use yii\base\Arrayable;
use yii\base\InvalidConfigException;
use yii\bootstrap\Alert;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\widgets\ActiveForm;
use kartik\base\Config;
use kartik\helpers\Html;
use kartik\base\WidgetTrait;
use kartik\base\TranslationTrait;

/**
 * Enhances the Yii DetailView widget with various options to include Bootstrap specific styling enhancements. Also
 * allows to simply disable Bootstrap styling by setting `bootstrap` to false. In addition, it allows you to directly
 * edit the detail grid data using a form.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class DetailView extends \yii\widgets\DetailView
{
    use WidgetTrait;
    use TranslationTrait;

    /**
     * Detail View Modes
     */
    const MODE_VIEW = 'view';
    const MODE_EDIT = 'edit';

    /**
     * Bootstrap Contextual Color Types
     */
    const TYPE_DEFAULT = 'default'; // only applicable for panel contextual style
    const TYPE_PRIMARY = 'primary';
    const TYPE_INFO = 'info';
    const TYPE_DANGER = 'danger';
    const TYPE_WARNING = 'warning';
    const TYPE_SUCCESS = 'success';
    const TYPE_ACTIVE = 'active'; // only applicable for table row contextual style

    /**
     * Alignment
     */
    // Horizontal Alignment
    const ALIGN_RIGHT = 'right';
    const ALIGN_CENTER = 'center';
    const ALIGN_LEFT = 'left';
    // Vertical Alignment
    const ALIGN_TOP = 'top';
    const ALIGN_MIDDLE = 'middle';
    const ALIGN_BOTTOM = 'bottom';

    /**
     * Edit input types
     */
    // input types
    const INPUT_TEXT = 'textInput';
    const INPUT_PASSWORD = 'passwordInput';
    const INPUT_TEXTAREA = 'textArea';
    const INPUT_CHECKBOX = 'checkbox';
    const INPUT_HIDDEN = 'hiddenInput';
    const INPUT_RADIO = 'radio';
    const INPUT_LIST_BOX = 'listBox';
    const INPUT_DROPDOWN_LIST = 'dropDownList';
    const INPUT_CHECKBOX_LIST = 'checkboxList';
    const INPUT_RADIO_LIST = 'radioList';
    const INPUT_FILE = 'fileInput';
    const INPUT_HTML5_INPUT = 'input';
    const INPUT_WIDGET = 'widget';
    const INPUT_DEPDROP = '\kartik\depdrop\DepDrop';
    const INPUT_SELECT2 = '\kartik\select2\Select2';
    const INPUT_TYPEAHEAD = '\kartik\typeahead\Typeahead';
    const INPUT_SWITCH = '\kartik\switchinput\SwitchInput';

    // input widget classes
    const INPUT_SPIN = '\kartik\touchspin\TouchSpin';
    const INPUT_RATING = '\kartik\widgets\StarRating';
    const INPUT_RANGE = '\kartik\range\RangeInput';
    const INPUT_COLOR = '\kartik\color\ColorInput';
    const INPUT_FILEINPUT = '\kartik\file\FileInput';
    const INPUT_DATE = '\kartik\date\DatePicker';
    const INPUT_TIME = '\kartik\time\TimePicker';
    const INPUT_DATETIME = '\kartik\datetime\DateTimePicker';
    const INPUT_DATE_RANGE = '\kartik\daterange\DateRangePicker';
    const INPUT_SORTABLE = '\kartik\sortinput\SortableInput';
    const INPUT_SLIDER = '\kartik\slider\Slider';
    const INPUT_MONEY = '\kartik\money\MaskMoney';
    const INPUT_CHECKBOX_X = '\kartik\checkbox\CheckboxX';

    // inputs list
    private static $_inputsList = [
        self::INPUT_HIDDEN => 'hiddenInput',
        self::INPUT_TEXT => 'textInput',
        self::INPUT_PASSWORD => 'passwordInput',
        self::INPUT_TEXTAREA => 'textArea',
        self::INPUT_CHECKBOX => 'checkbox',
        self::INPUT_RADIO => 'radio',
        self::INPUT_LIST_BOX => 'listBox',
        self::INPUT_DROPDOWN_LIST => 'dropDownList',
        self::INPUT_CHECKBOX_LIST => 'checkboxList',
        self::INPUT_RADIO_LIST => 'radioList',
        self::INPUT_HTML5_INPUT => 'input',
        self::INPUT_FILE => 'fileInput',
        self::INPUT_WIDGET => 'widget',
    ];

    // dropdown inputs
    private static $_dropDownInputs = [
        self::INPUT_LIST_BOX => 'listBox',
        self::INPUT_DROPDOWN_LIST => 'dropDownList',
        self::INPUT_CHECKBOX_LIST => 'checkboxList',
        self::INPUT_RADIO_LIST => 'radioList',
    ];

    /**
     * @var string the mode for the Detail View when its initialized
     */
    public $mode = self::MODE_VIEW;

    /**
     * @var integer the fade animation delay in microseconds when toggling between the view and edit modes.
     */
    public $fadeDelay = 800;

    /**
     * @var string the horizontal alignment for the label column
     */
    public $hAlign = self::ALIGN_RIGHT;

    /**
     * @var string the vertical alignment for the label column
     */
    public $vAlign = self::ALIGN_MIDDLE;

    /**
     * @var array the HTML attributes for each attribute row
     */
    public $rowOptions = [];

    /**
     * @var array the HTML attributes for the label column
     */
    public $labelColOptions = ['style' => 'width: 20%'];

    /**
     * @var array the HTML attributes for the value column
     */
    public $valueColOptions = [];

    /**
     * @var bool whether to hide all alerts. Defaults to `false`.
     */
    public $hideAlerts = false;

    /**
     * @var bool whether to show values as not set if empty string
     */
    public $notSetIfEmpty = false;

    /**
     * @var array the HTML attributes for the alert block container which will display any alert messages received on
     *     update or delete of record. This will not be displayed if there are no alert messages.
     */
    public $alertContainerOptions = [];

    /**
     * @var array the widget settings for each bootstrap alert displayed in the alert container block.
     * The CSS class in `options` within this will be auto derived and appended.
     * - For `update` error messages will be displayed if you have set messages using Yii::$app->session->setFlash. The
     *     CSS class for the error block will be auto-derived based on flash message type using `alertMessageSettings`.
     * - For `delete` this will be displayed based on the ajax response. The ajax response should be an object that
     *     contain the following:
     *   - success: `boolean`, whether the ajax delete is successful.
     *   - messages: `array|object`,the list of messages to display as key value pairs. The key must be one of the
     *     message keys in the `alertMessageSettings`, and the value must be the message content to be displayed.
     */
    public $alertWidgetOptions = [];

    /**
     * @var array the flash message settings which will be set as $key => $value, where
     * - `$key`: flash message key e.g. `error`, `success`.
     * - `$value`: CSS class for the flash message e.g. `alert alert-danger`, `alert alert-success`. This defaults to
     *     the following setting:
     * ```
     *  [
     *      'kv-detail-error' => 'alert alert-danger',
     *      'kv-detail-success' => 'alert alert-success',
     *      'kv-detail-info' => 'alert alert-info',
     *      'kv-detail-warning' => 'alert alert-warning'
     *  ]
     * ```
     */
    public $alertMessageSettings = [];

    /**
     * @var array the HTML attributes for the detail view table
     */
    public $options = [];

    /**
     * @var bool whether the grid view will have Bootstrap table styling.
     */
    public $bootstrap = true;

    /**
     * @var bool whether the grid table will have a `bordered` style. Applicable only if `bootstrap` is `true`.
     *     Defaults to `true`.
     */
    public $bordered = true;

    /**
     * @var bool whether the grid table will have a `striped` style. Applicable only if `bootstrap` is `true`. Defaults
     *     to `true`.
     */
    public $striped = true;

    /**
     * @var bool whether the grid table will have a `condensed` style. Applicable only if `bootstrap` is `true`.
     *     Defaults to `false`.
     */
    public $condensed = false;

    /**
     * @var bool whether the grid table will have a `responsive` style. Applicable only if `bootstrap` is `true`.
     *     Defaults to `true`.
     */
    public $responsive = true;

    /**
     * @var bool whether the grid table will highlight row on `hover`. Applicable only if `bootstrap` is `true`.
     *     Defaults to `false`.
     */
    public $hover = false;

    /**
     * @var bool whether to enable edit mode for the detail view. Defaults to `true`.
     */
    public $enableEditMode = true;

    /**
     * @var bool whether to hide rows in view mode if value is null or empty.
     */
    public $hideIfEmpty = false;

    /**
     * @var bool whether to display bootstrap style tooltips for titles on hover of buttons
     */
    public $tooltips = true;

    /**
     * @var array a list of attributes to be displayed in the detail view. Each array element represents the
     *     specification for displaying one particular attribute.
     *
     * An attribute can be specified as a string in the format of "attribute", "attribute:format" or
     *     "attribute:format:label", where "attribute" refers to the attribute name, and "format" represents the format
     *     of the attribute. The "format" is passed to the [[Formatter::format()]] method to format an attribute value
     *     into a displayable text. Please refer to [[Formatter]] for the supported types. Both "format" and "label"
     *     are optional. They will take default values if absent.
     *
     * An attribute can also be specified in terms of an array with the following elements:
     *
     * - attribute: the attribute name. This is required if either "label" or "value" is not specified.
     * - label: the label associated with the attribute. If this is not specified, it will be generated from the
     *     attribute name.
     * - value: the value to be displayed. If this is not specified, it will be retrieved from [[model]] using the
     *     attribute name by calling [[ArrayHelper::getValue()]]. Note that this value will be formatted into a
     *     displayable text according to the "format" option.
     * - format: the type of the value that determines how the value would be formatted into a displayable text. Please
     *     refer to [[Formatter]] for supported types.
     * - visible: whether the attribute is visible. If set to `false`, the attribute will NOT be displayed.
     *
     * Additional special settings are:
     * - viewModel: Model, the model to be used for this attribute in VIEW mode. This will override the `model` setting
     *     at the widget level. If not set, the widget `model` setting will be used.
     * - editModel: Model, the model to be used for this attribute in EDIT mode. This will override the `model` setting
     *     at the widget level. If not set, the widget `model` setting will be used.
     * - rowOptions: array, HTML attributes for the row (if not set, this will be defaulted to the `rowOptions` set at
     *     the widget level)
     * - labelColOptions: array, HTML attributes for the label column (if not set, this will be defaulted to the
     *     `labelColOptions` set at the widget level)
     * - valueColOptions: array, HTML attributes for the value column (if not set, this will be defaulted to
     *     `valueColOptions` set at the widget level)
     * - group: bool, whether to group the selection by merging the label and value into a single column.
     * - groupOptions: array, HTML attributes for the grouped/merged column when `group` is set to `true`.
     * - type: string, the input type for rendering the attribute in edit mode. Must be one of the
     *     [[DetailView::::INPUT_]] constants.
     * - displayOnly: boolean, if the input is to be set to as `display only` in edit mode.
     * - widgetOptions: array, the widget options if you set `type` to [[DetailView::::INPUT_WIDGET]]. The following
     *     special options are recognized:
     *   - `class`: string the fully namespaced widget class.
     * - items: array, the list of data items  for dropDownList, listBox, checkboxList & radioList
     * - inputType: string, the HTML 5 input type if `type` is set to [[DetailView::::INPUT_HTML 5]].
     * - inputContainer: array, HTML attributes for the input container
     * - inputWidth: string, the width of the container holding the input, should be appended along with the width unit
     *     (`px` or `%`) - this property is deprecated since v1.7.4
     * - fieldConfig: array, optional, the Active field configuration.
     * - options: array, optional, the HTML attributes for the input.
     * - updateAttr: string, optional, the name of the attribute to be updated, when in edit mode. This will default to
     *     the `attribute` setting.
     */
    public $attributes;

    /**
     * @var array the options for the ActiveForm that will be generated in edit mode.
     */
    public $formOptions = [];

    /**
     * @var string the ActiveForm widget class
     */
    public $formClass = 'yii\widgets\ActiveForm';

    /**
     * @var array the panel settings. If this is set, the grid widget
     * will be embedded in a bootstrap panel. Applicable only if `bootstrap`
     * is `true`. The following array keys are supported:
     * - `heading`: string | boolean, the panel heading title value. If set to false, the entire heading will be not
     *     displayed. Note that the `{title}` tag in the `headingOptions['template']` will be replaced with this value.
     * - `headingOptions`: array, the HTML attributes for the panel heading. Defaults to `['class'=>'panel-title']`.
     *     The following additional options are available:
     *   - `tag`: string, the tag to render the heading. Defaults to `h3`.
     *   - `template`: string, the template to render the heading. Defaults to `{buttons}{title}`, where:
     *      - `{title}` will be replaced with the `heading` value, and
     *      -`{buttons}` will be replaced by the rendered buttons.
     * - `type`: string, the panel contextual type (one of the TYPE constants, if not set will default to `default` or
     *     `self::TYPE_DEFAULT`)
     * - `footer`: string | boolean, the panel footer title value. Defaults to `false`. If set to false, the entire
     *     footer will be not displayed. Note that the `{title}` tag in the `footerOptions['template']` will be
     *     replaced with this value.
     * - `footerOptions`: array, the HTML attributes for the panel footer. Defaults to `['class'=>'panel-title']`. The
     *     following additional options are available:
     *   - `tag`: string, the tag to render the footer. Defaults to `h4`.
     *   - `template`: string, the template to render the footer. Defaults to `{title}`, where:
     *      - `{title}` will be replaced with the `footer`, and
     *      -`{buttons}` will be replaced by the rendered buttons.
     */
    public $panel = [];

    /**
     * @var string the main template to render the detail view. The following tags will be replaced:
     * - `{detail}`: will be replaced by the rendered detail view
     * - `{buttons}`: the buttons to be displayed as set in `buttons1` and
     *    `buttons2`.
     */
    public $mainTemplate = "{detail}";

    /**
     * @var array the options for the button toolbar container
     */
    public $buttonContainer = ['class' => 'pull-right'];

    /**
     * @var string the buttons to show when in view mode. The following tags will be replaced:
     * - `{view}`: the view button
     * - `{update}`: the update button
     * - `{delete}`: the delete button
     * - `{save}`: the save button
     * Defaults to `{edit} {delete}`.
     */
    public $buttons1 = '{update} {delete}';

    /**
     * @var string the buttons template to show when in edit mode. The following tags will be replaced:
     * - `{view}`: the view button
     * - `{update}`: the update button
     * - `{reset}`: the reset button
     * - `{delete}`: the delete button
     * - `{save}`: the save button
     * Defaults to `{view} {save}`.
     */
    public $buttons2 = '{view} {reset} {save}';

    /**
     * @var array the HTML attributes for the container displaying the VIEW mode attributes.
     */
    public $viewAttributeContainer = [];

    /**
     * @var array the HTML attributes for the container displaying the EDIT mode attributes.
     */
    public $editAttributeContainer = [];

    /**
     * @var array the HTML attributes for the container displaying the VIEW mode buttons.
     */
    public $viewButtonsContainer = [];

    /**
     * @var array the HTML attributes for the container displaying the EDIT mode buttons.
     */
    public $editButtonsContainer = [];

    /**
     * @var array the HTML attributes for the view button. This will toggle the view from edit mode to view mode. The
     *     following special options are recognized:
     * - `label`: the save button label. This will not be HTML encoded.
     *    Defaults to '<span class="glyphicon glyphicon-eye-open"></span>'.
     */
    public $viewOptions = [];

    /**
     * @var array the HTML attributes for the update button. This button will toggle the edit mode on. The following
     *     special options are recognized:
     * - `label`: the update button label. This will not be HTML encoded.
     *    Defaults to '<span class="glyphicon glyphicon-pencil"></span>'.
     */
    public $updateOptions = [];

    /**
     * @var array the HTML attributes for the reset button. This button will reset the form in edit mode. The following
     *     special options are recognized:
     * - `label`: the reset button label. This will not be HTML encoded.
     *    Defaults to '<span class="glyphicon glyphicon-ban-circle"></span>'.
     */
    public $resetOptions = [];

    /**
     * @var array the HTML attributes for the edit button. The following special options are recognized:
     * - `label`: the delete button label. This will not be HTML encoded. Defaults to '<span class="glyphicon
     *     glyphicon-trash"></span>'.
     * - `url`: the delete button url. If not set will default to `#`.
     * - `params`: array, the parameters to be passed via ajax which you must set as key value pairs. This will be
     *     automatically json encoded, so you can set JsExpression or callback
     * - `ajaxSettings`: array, the ajax settings if you choose to override the delete ajax settings.
     * @see http://api.jquery.com/jquery.ajax/
     * - `confirm': string, the confirmation message before triggering delete. Defaults to Yii::t('kvdetail', 'Are you
     *     sure you want to delete this item?')
     * - `showErrorStack`: boolean, whether to show the complete error stack.
     */
    public $deleteOptions = [];

    /**
     * @var array the HTML attributes for the save button. This will default to a form submit button.
     * The following special options are recognized:
     * - `label`: the save button label. This will not be HTML encoded. Defaults to '<span class="glyphicon
     *     glyphicon-floppy-disk"></span>'.
     */
    public $saveOptions = [];

    /**
     * @var array the HTML attributes for the widget container
     */
    public $container = [];

    /**
     * @var array the the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @var string the Detail View plugin name
     */
    public $pluginName = 'kvDetailView';

    /**
     * @var array the Detail View plugin options
     */
    public $pluginOptions = [];

    /**
     * @var string the Detail View plugin destroy JS
     */
    public $pluginDestroyJs;

    /**
     * @var string translation message file category name for i18n
     */
    protected $_msgCat = 'kvdetail';

    /**
     * @var string the hashed global variable name storing the pluginOptions
     */
    protected $_hashVar;

    /**
     * @var string the element's HTML5 data variable name storing the pluginOptions
     */
    protected $_dataVar;

    /**
     * @var string the Json encoded options
     */
    protected $_encOptions = '';

    /**
     * @var ActiveForm the form instance
     */
    protected $_form;

    /**
     * @var array HTML attributes for child tables
     */
    protected $_childTableOptions = [];

    /**
     * @var array HTML attributes for table row
     */
    protected $_rowOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initWidget();
        parent:: init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->runWidget();
    }

    /**
     * Initializes the detail view widget
     *
     * @throws InvalidConfigException
     */
    protected function initWidget()
    {
        /**
         * @var ActiveForm $formClass
         */
        $formClass = $this->formClass;
        if ($this->enableEditMode) {
            $activeForm = ActiveForm::classname();
            if (!is_subclass_of($formClass, $activeForm) && $formClass !== $activeForm) {
                throw new InvalidConfigException("Form class '{$formClass}' must exist and extend from '{$activeForm}'.");
            }
            $this->validateDisplay();
        }
        if ($this->bootstrap) {
            Html::addCssClass($this->options, 'table');
            if ($this->hover) {
                Html::addCssClass($this->options, 'table-hover');
            }
            if ($this->bordered) {
                Html::addCssClass($this->options, 'table-bordered');
            }
            if ($this->condensed) {
                Html::addCssClass($this->options, 'table-condensed');
            }
            $this->_childTableOptions = $this->options;
            if ($this->striped) {
                Html::addCssClass($this->options, 'table-striped');
            }
        }
        Html::addCssClass($this->_childTableOptions, 'kv-child-table');
        Html::addCssClass($this->options, 'detail-view');
        Html::addCssStyle($this->labelColOptions, "text-align:{$this->hAlign};vertical-align:{$this->vAlign};");
    }

    /**
     * Prepares and runs the detail view widget
     */
    protected function runWidget()
    {
        /**
         * @var ActiveForm $formClass
         */
        $formClass = $this->formClass;
        if (empty($this->container['id'])) {
            $this->container['id'] = $this->getId();
        }
        $this->initI18N(__DIR__);
        if ($this->enableEditMode) {
            $this->formOptions['fieldConfig']['template'] = "{input}\n{hint}\n{error}";
            $this->_form = $formClass::begin($this->formOptions);
        }
        Html::addCssClass($this->alertContainerOptions, 'panel-body kv-alert-container');
        $this->alertMessageSettings += [
            'kv-detail-error' => 'alert alert-danger',
            'kv-detail-success' => 'alert alert-success',
            'kv-detail-info' => 'alert alert-info',
            'kv-detail-warning' => 'alert alert-warning'
        ];
        $this->registerAssets();
        $output = $this->renderDetailView();
        if (is_array($this->panel) && !empty($this->panel) && $this->panel !== false) {
            $output = $this->renderPanel($output);
        }
        $output = strtr(
            $this->mainTemplate,
            ['{detail}' => Html::tag('div', $output, $this->container)]
        );
        Html::addCssClass($this->viewButtonsContainer, 'kv-buttons-1');
        $buttons = Html::tag('span', $this->renderButtons(1), $this->viewButtonsContainer);
        if ($this->enableEditMode) {
            Html::addCssClass($this->editButtonsContainer, 'kv-buttons-2');
            $buttons .= Html::tag('span', $this->renderButtons(2), $this->editButtonsContainer);
        }
        echo str_replace('{buttons}', Html::tag('div', $buttons, $this->buttonContainer), $output);
        if ($this->enableEditMode) {
            $formClass::end();
        }
    }

    /**
     * Initializes and renders alert container block
     */
    protected function renderAlertBlock()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        if (count($flashes) === 0) {
            Html::addCssStyle($this->alertContainerOptions, 'display:none;');
        }
        $out = Html::beginTag('div', $this->alertContainerOptions);
        foreach ($flashes as $type => $message) {
            $class = ArrayHelper::getValue($this->alertMessageSettings, $type, 'alert alert-' . $type);
            $options = ArrayHelper::getValue($this->alertWidgetOptions, 'options', []);
            Html::addCssClass($options, $class);
            $this->alertWidgetOptions['body'] = $message;
            $this->alertWidgetOptions['options'] = $options;
            $out .= "\n" . Alert::widget($this->alertWidgetOptions);
            $session->removeFlash($type);
        }
        $out .= "\n</div>";
        return $out;
    }

    /**
     * Check if model has editing errors
     *
     * @return boolean
     */
    protected function hasEditErrors()
    {
        if (count($this->model->getErrors()) > 0) {
            return true;
        }
        foreach ($this->attributes as $attribute) {
            /**
             * @var Model $attribute ['editModel']
             */
            if (empty($attribute['editModel']) || !$attribute['editModel'] instanceof Model) {
                continue;
            }
            if ($attribute['editModel']->getErrors() > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validates the display of correct attributes and buttons
     * at initialization based on mode
     *
     * @return void
     */
    protected function validateDisplay()
    {
        $none = 'display:none';
        if ($this->hasEditErrors()) {
            $this->mode = self::MODE_EDIT;
        }
        if ($this->mode === self::MODE_EDIT) {
            Html::addCssClass($this->container, 'kv-edit-mode');
            Html::addCssStyle($this->viewAttributeContainer, $none);
            Html::addCssStyle($this->viewButtonsContainer, $none);
        } else {
            Html::addCssClass($this->container, 'kv-view-mode');
            Html::addCssStyle($this->editAttributeContainer, $none);
            Html::addCssStyle($this->editButtonsContainer, $none);
        }
    }

    /**
     * Renders the main detail view widget
     *
     * @return string the detail view content
     */
    protected function renderDetailView()
    {
        $rows = [];
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttributeRow($attribute);
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'table');
        $output = Html::tag($tag, implode("\n", $rows), $this->options);
        return ($this->bootstrap && $this->responsive) ?
            '<div class="table-responsive kv-detail-view">' . $output . '</div>' :
            '<div class="kv-detail-view">' . $output . '</div>';
    }

    /**
     * Renders a single attribute.
     *
     * @param array $attribute the specification of the attribute to be rendered.
     *
     * @return string the rendering result
     */
    protected function renderAttributeRow($attribute)
    {
        $this->_rowOptions = ArrayHelper::getValue($attribute, 'rowOptions', $this->rowOptions);
        if (isset($attribute['columns'])) {
            Html::addCssClass($this->_rowOptions, 'kv-child-table-row');
            $content = '<td class="kv-child-table-cell" colspan=2><table class="kv-child-table"><tr>';
            if (!empty($child['attribute'])) {
                $childName = $child['attribute'];
                if (!isset($child['label'])) {
                    $child['label'] = $this->model instanceof Model ?
                        $this->model->getAttributeLabel($childName) :
                        Inflector::camel2words($childName, true);
                }
                if (!array_key_exists('value', $child)) {
                    $child['value'] = ArrayHelper::getValue($this->model, $childName);
                }
            }
            foreach ($attribute['columns'] as $child) {
                $content .= $this->renderAttributeItem($child);
            }
            $content .= '</tr></table></td>';
        } else {
            $content = $this->renderAttributeItem($attribute);
        }
        return Html::tag('tr', $content, $this->_rowOptions);
    }

    /**
     * Renders a single attribute item combination.
     *
     * @param array $attribute the specification of the attribute to be rendered.
     *
     * @return string the rendering result
     */
    protected function renderAttributeItem($attribute)
    {
        $labelColOpts = ArrayHelper::getValue($attribute, 'labelColOptions', $this->labelColOptions);
        $valueColOpts = ArrayHelper::getValue($attribute, 'valueColOptions', $this->valueColOptions);
        if (ArrayHelper::getValue($attribute, 'group', false)) {
            $groupOptions = ArrayHelper::getValue($attribute, 'groupOptions', []);
            $label = ArrayHelper::getValue($attribute, 'label', '');
            if (empty($groupOptions['colspan'])) {
                $groupOptions['colspan'] = 2;
            }
            return Html::tag('th', $label, $groupOptions);
        }
        if ($this->hideIfEmpty === true && empty($attribute['value'])) {
            Html::addCssClass($this->_rowOptions, 'kv-view-hidden');
        }
        if (ArrayHelper::getValue($attribute, 'type', 'text') === self::INPUT_HIDDEN) {
            Html::addCssClass($this->_rowOptions, 'kv-edit-hidden');
        }
        $value = $attribute['value'];
        if ($this->notSetIfEmpty && ($value === '' || $value === null)) {
            $value = null;
        }
        $dispAttr = $this->formatter->format($value, $attribute['format']);
        Html::addCssClass($this->viewAttributeContainer, 'kv-attribute');
        Html::addCssClass($this->editAttributeContainer, 'kv-form-attribute');
        $output = Html::tag('div', $dispAttr, $this->viewAttributeContainer) . "\n";
        if ($this->enableEditMode) {
            $editInput = ArrayHelper::getValue($attribute, 'displayOnly', false) ? $dispAttr :
                $this->renderFormAttribute($attribute);
            $output .= Html::tag('div', $editInput, $this->editAttributeContainer);
        }
        return Html::tag('th', $attribute['label'], $labelColOpts) . "\n" . Html::tag('td', $output, $valueColOpts);
    }

    /**
     * Checks if a bootstrap grid column class has been added to the container
     *
     * @param array $container
     *
     * @return boolean
     */
    protected static function hasGridCol($container = [])
    {
        $css = ArrayHelper::getValue($container, 'class', '');
        $css = trim($css);
        $css = preg_replace('/\s+/', ' ', $css);
        if (empty($css)) {
            return false;
        }
        $classes = explode(' ', $css);
        if (!empty($classes)) {
            foreach ($classes as $class) {
                if (substr(trim($class), 0, 4) === 'col-') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Renders each form attribute
     *
     * @param array $config the attribute config
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    protected function renderFormAttribute($config)
    {
        if (empty($config['attribute'])) {
            return '';
        }
        $model = ArrayHelper::getValue($config, 'editModel', $this->model);
        if (!$model instanceof Model) {
            $model = $this->model;
        }
        $attr = ArrayHelper::getValue($config, 'updateAttr', $config['attribute']);
        $input = ArrayHelper::getValue($config, 'type', self::INPUT_TEXT);
        $fieldConfig = ArrayHelper::getValue($config, 'fieldConfig', []);
        $inputWidth = ArrayHelper::getValue($config, 'inputWidth', '');
        $container = ArrayHelper::getValue($config, 'inputContainer', []);
        if ($inputWidth != '') {
            Html::addCssStyle($container, "width: {$inputWidth}"); // deprecated since v1.7.4
        }
        $template = ArrayHelper::getValue($fieldConfig, 'template', "{input}\n{error}\n{hint}");
        $row = Html::tag('div', $template, $container);
        if (static::hasGridCol($container)) {
            $row = '<div class="row">' . $row . '</div>';
        }
        $fieldConfig['template'] = $row;
        if (substr($input, 0, 8) == "\\kartik\\") {
            Config::validateInputWidget($input, 'as an input widget for DetailView edit mode');
        } elseif ($input !== self::INPUT_WIDGET && !in_array($input, self::$_inputsList)) {
            throw new InvalidConfigException(
                "Invalid input type '{$input}' defined for the attribute '" . $config['attribute'] . "'."
            );
        }
        $options = ArrayHelper::getValue($config, 'options', []);
        $widgetOptions = ArrayHelper::getValue($config, 'widgetOptions', []);
        $class = ArrayHelper::remove($widgetOptions, 'class', '');
        if (!empty($config['options'])) {
            $widgetOptions['options'] = $config['options'];
        }
        if (Config::isInputWidget($input)) {
            $class = $input;
            return $this->_form->field($model, $attr, $fieldConfig)->widget($class, $widgetOptions);
        }
        if ($input === self::INPUT_WIDGET) {
            if ($class == '') {
                throw new InvalidConfigException("Widget class not defined in 'widgetOptions' for {$input}'.");
            }
            return $this->_form->field($model, $attr, $fieldConfig)->widget($class, $widgetOptions);
        }
        if (in_array($input, self::$_dropDownInputs)) {
            $items = ArrayHelper::getValue($config, 'items', []);
            return $this->_form->field($model, $attr, $fieldConfig)->$input($items, $options);
        }
        if ($input == self::INPUT_HTML5_INPUT) {
            $inputType = ArrayHelper::getValue($config, 'inputType', self::INPUT_TEXT);
            return $this->_form->field($model, $attr, $fieldConfig)->$input($inputType, $options);
        }
        return $this->_form->field($model, $attr, $fieldConfig)->$input($options);
    }

    /**
     * Returns the bootstrap panel
     *
     * @param string $content
     *
     * @return string
     */
    protected function renderPanel($content)
    {
        $panel = $this->panel;
        $type = ArrayHelper::remove($panel, 'type', self::TYPE_DEFAULT);
        if (($heading = $this->renderPanelTitleBar('heading')) !== false) {
            $panel['heading'] = $heading;
        }
        if (($footer = $this->renderPanelTitleBar('footer')) !== false) {
            $panel['footer'] = $footer;
        }
        $alertBlock = $this->hideAlerts ? '' : $this->renderAlertBlock() . "\n";
        $panel['preBody'] = $alertBlock . $content;
        return Html::panel($panel, $type);
    }

    /**
     * Renders the panel title bar
     *
     * @param string $type whether 'heading' or 'footer'
     *
     * @return string | boolean
     */
    protected function renderPanelTitleBar($type)
    {
        $title = ArrayHelper::getValue($this->panel, $type, ($type === 'heading' ? '' : false));
        if ($title === false) {
            return false;
        }
        $options = ArrayHelper::getValue($this->panel, $type . 'Options', []);
        $tag = ArrayHelper::remove($options, 'tag', ($type === 'heading' ? 'h3' : 'h4'));
        $template = ArrayHelper::remove($options, 'template', ($type === 'heading' ? '{buttons}{title}' : '{title}'));
        Html::addCssClass($options, 'panel-title');
        $title = Html::tag($tag, $title, $options);
        return str_replace('{title}', $title, $template);
    }

    /**
     * Renders the buttons for a specific mode
     *
     * @param integer $mode
     *
     * @return string the buttons content
     */
    protected function renderButtons($mode = 1)
    {
        $buttons = "buttons{$mode}";
        return strtr(
            $this->$buttons,
            [
                '{view}' => $this->renderButton('view'),
                '{update}' => $this->renderButton('update'),
                '{delete}' => $this->renderButton('delete'),
                '{save}' => $this->renderButton('save'),
                '{reset}' => $this->renderButton('reset'),
            ]
        );
    }

    /**
     * Renders a button
     *
     * @param string $type the button type
     *
     * @return string
     */
    protected function renderButton($type)
    {
        if (!$this->enableEditMode) {
            return '';
        }
        switch ($type) {
            case 'view':
                return $this->getDefaultButton('view', 'eye-open', Yii::t('kvdetail', 'View'));
            case 'update':
                return $this->getDefaultButton('update', 'pencil', Yii::t('kvdetail', 'Update'));
            case 'delete':
                return $this->getDefaultButton('delete', 'trash', Yii::t('kvdetail', 'Delete'));
            case 'save':
                return $this->getDefaultButton('save', 'floppy-disk', Yii::t('kvdetail', 'Save'));
            case 'reset':
                return $this->getDefaultButton('reset', 'ban-circle', Yii::t('kvdetail', 'Cancel Changes'));
            default:
                return '';
        }
    }

    /**
     * Gets the default button
     *
     * @param string $type the button type
     * @param string $icon the glyphicon icon suffix name
     * @param string $title the title to display on hover
     *
     * @return string
     */
    protected function getDefaultButton($type, $icon, $title)
    {
        $buttonOptions = $type . 'Options';
        $options = $this->$buttonOptions;
        $label = ArrayHelper::remove($options, 'label', "<i class='glyphicon glyphicon-{$icon}'></i>");
        if (empty($options['class'])) {
            $options['class'] = 'kv-action-btn';
        }
        Html::addCssClass($options, 'kv-btn-' . $type);
        $options = ArrayHelper::merge(['title' => $title], $options);
        if ($this->tooltips) {
            $options['data-toggle'] = 'tooltip';
            $options['data-container'] = 'body';
        }
        switch ($type) {
            case 'reset':
                return Html::resetButton($label, $options);
            case 'save':
                return Html::submitButton($label, $options);
            case 'delete':
                $url = ArrayHelper::remove($options, 'url', '#');
                return Html::a($label, $url, $options);
        }
        $options['type'] = 'button';
        return Html::button($label, $options);
    }

    /**
     * Register assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        DetailViewAsset::register($view);
        if (empty($this->alertWidgetOptions['closeButton'])) {
            $button = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        } else {
            $opts = $this->alertWidgetOptions['closeButton'];
            $tag = ArrayHelper::remove($opts, 'tag', 'button');
            $label = ArrayHelper::remove($opts, 'label', '&times;');
            if ($tag === 'button' && !isset($opts['type'])) {
                $opts['type'] = 'button';
            }
            $button = Html::tag($tag, $label, $opts);
        }
        $opts = ArrayHelper::getValue($this->alertWidgetOptions, 'options', []);
        if (!empty($opts['class'])) {
            $opts['class'] .= ' {class} fade in';
        } else {
            $opts['class'] = '{class} fade in';
        }
        $deleteConfirmMsg = Yii::t('kvdetail', 'Are you sure you want to delete this item?');
        $this->pluginOptions = [
            'fadeDelay' => $this->fadeDelay,
            'alertTemplate' => Html::tag('div', $button . '{content}', $opts),
            'alertMessageSettings' => $this->alertMessageSettings,
            'deleteParams' => ArrayHelper::getValue($this->deleteOptions, 'params', []),
            'deleteAjaxSettings' => ArrayHelper::getValue($this->deleteOptions, 'ajaxSettings', []),
            'deleteConfirm' => ArrayHelper::remove($this->deleteOptions, 'confirm', $deleteConfirmMsg),
            'showErrorStack' => ArrayHelper::remove($this->deleteOptions, 'showErrorStack', false)
        ];
        $id = 'jQuery("#' . $this->container['id'] . '")';
        if ($this->enableEditMode) {
            $options['mode'] = $this->mode;
        }
        $this->registerPlugin($this->pluginName, $id);
        if ($this->tooltips) {
            $view->registerAssetBundle('yii\bootstrap\BootstrapPluginAsset');
            $view->registerJs($id . '.find("[data-toggle=tooltip]").tooltip();');
        }
    }

    /**
     * Normalizes the attribute specifications.
     *
     * @throws InvalidConfigException
     */
    protected function normalizeAttributes()
    {
        if ($this->attributes === null) {
            if ($this->model instanceof Model) {
                $this->attributes = $this->model->attributes();
            } elseif (is_object($this->model)) {
                $this->attributes = $this->model instanceof Arrayable ? $this->model->toArray() :
                    array_keys(get_object_vars($this->model));
            } elseif (is_array($this->model)) {
                $this->attributes = array_keys($this->model);
            } else {
                throw new InvalidConfigException('The "model" property must be either an array or an object.');
            }
            sort($this->attributes);
        }
        foreach ($this->attributes as $i => $attribute) {
            $this->attributes[$i] = $this->parseAttributeItem($attribute);
            if (isset($attribute['visible']) && !$attribute['visible']) {
                unset($this->attributes[$i]);
            }
        }
    }

    /**
     * Parses and returns the attribute
     *
     * @param string|array $attribute the attribute item configuration
     *
     * @return array the parsed attribute item configuration
     * @throws InvalidConfigException
     */
    protected function parseAttributeItem($attribute)
    {
        if (is_string($attribute)) {
            if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $attribute, $matches)) {
                throw new InvalidConfigException(
                    'The attribute must be specified in the format of "attribute", "attribute:format" or ' .
                    '"attribute:format:label"'
                );
            }
            $attribute = [
                'attribute' => $matches[1],
                'format' => isset($matches[3]) ? $matches[3] : 'text',
                'label' => isset($matches[5]) ? $matches[5] : null,
            ];
        }
        if (!is_array($attribute)) {
            throw new InvalidConfigException('The attribute configuration must be an array.');
        }
        if (isset($attribute['columns'])) {
            foreach ($attribute['columns'] as $j => $child) {
                $attr = $this->parseAttributeItem($child);
                if (isset($attr['visible']) && !$attr['visible']) {
                    unset($attribute['columns'][$j]);
                    continue;
                }
                $attribute['columns'][$j] = $attr;
            }
            return $attribute;
        }
        $attr = ArrayHelper::getValue($attribute, 'updateAttr');
        if ($attr && !ctype_alnum(str_replace('_', '', $attr))) {
            throw new InvalidConfigException("The 'updateAttr' name '{$attr}' is invalid.");
        }
        $attr = ArrayHelper::getValue($attribute, 'attribute', '');
        if ($attr && strpos($attr, '.') !== false) {
            throw new InvalidConfigException(
                "The attribute '{$attr}' is invalid. You cannot directly pass relational attributes in string format " .
                "within '\\kartik\\widgets\\DetailView'. Instead use the array format with 'attribute' property " .
                "set to base field, and the 'value' property returning the relational data. You can also override the " .
                "widget 'model' settings by setting the 'viewModel' and / or 'editModel' at the attribute array level."
            );
        }
        if (!isset($attribute['format'])) {
            $attribute['format'] = 'text';
        }
        if (isset($attribute['attribute'])) {
            $attributeName = $attribute['attribute'];
            $model = !empty($attribute['viewModel']) && $attribute['viewModel'] instanceof Model ?
                $attribute['viewModel'] : $this->model;
            if (!isset($attribute['label'])) {
                $attribute['label'] = $model instanceof Model ? $model->getAttributeLabel($attributeName) :
                    Inflector::camel2words($attributeName, true);
            }
            if (!array_key_exists('value', $attribute)) {
                $attribute['value'] = ArrayHelper::getValue($model, $attributeName);
            }
        } elseif (!isset($attribute['label']) || !array_key_exists('value', $attribute)) {
            if (ArrayHelper::getValue($attribute, 'group', false) || isset($attribute['columns'])) {
                $attribute['value'] = '';
                return $attribute;
            }
            throw new InvalidConfigException(
                'The attribute configuration requires the "attribute" element to determine the value and display label.'
            );
        }
        return $attribute;
    }
}
