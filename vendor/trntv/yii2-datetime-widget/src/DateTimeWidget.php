<?php
namespace trntv\yii\datetime;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use trntv\yii\datetime\assets\DateTimeAsset;

/**
 * Class DateTimeWidget
 * @package yii2-datetime-widget
 */
class DateTimeWidget extends InputWidget
{
    /**
     * @var array
     * Full list of available client options see here:
     * @link http://eonasdan.github.io/bootstrap-datetimepicker/#options
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying bootstrap-datetimepicker plugin.
     */
    public $clientEvents = [];
    /**
     * @var array
     */
    public $containerOptions = [];
    /**
     * @var array
     */
    public $inputAddonOptions = [];
    /**
     * @var string
     */
    public $phpDatetimeFormat = 'dd.MM.yyyy, HH:mm';
    /**
     * @var
     */
    public $momentDatetimeFormat;

    /**
     * @var bool
     */
    public $showInputAddon = true;
    /**
     * @var string
     */
    public $inputAddonContent;
    /**
     * @var array
     */
    public $phpMomentMapping = [];
    /**
     * @var string Moment.js locale
     * Full list of available locales are here:
     * @link https://github.com/moment/moment/tree/develop/locale
     */
    public $locale;

    /**
     * @var array
     */
    protected $defaultPhpMomentMapping = [
        "yyyy-MM-dd'T'HH:mm:ssZZZZZ" => 'YYYY-MM-DDTHH:mm:ssZZ', // 2014-05-14T13:55:01+02:00
        "dd-MM-yyyy'T'HH:mm:ssZZZZZ" => 'DD-MM-YYYYTHH:mm:ssZZ', // 14-05-2014T13:55:01+02:00
        "yyyy-MM-dd"                 => 'YYYY-MM-DD',            // 2014-05-14
        "dd.MM.yyyy, HH:mm"          => 'DD.MM.YYYY, HH:mm',     // 14.05.2014, 13:55, German format without seconds
        "dd.MM.yyyy, HH:mm:ss"       => 'DD.MM.YYYY, HH:mm:ss',  // 14.05.2014, 13:55:01, German format with seconds
        "dd/MM/yyyy"                 => 'DD/MM/YYYY',            // 14/05/2014, British ascending format
        "dd/MM/yyyy HH:mm"           => 'DD/MM/YYYY HH:mm',      // 14/05/2014 13:55, British ascending format with time
        "EE, dd/MM/yyyy HH:mm"       => 'ddd, DD/MM/YYYY HH:mm', // Wed, 14/05/2014 13:55, includes day of week in British format
    ];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        $this->momentDatetimeFormat = $this->momentDatetimeFormat ?: ArrayHelper::getValue(
            $this->getPhpMomentMappings(),
            $this->phpDatetimeFormat
        );
        if (!$this->momentDatetimeFormat) {
            throw new InvalidConfigException('Please set momentjs datetime format');
        }
        // Init default clientOptions
        $this->clientOptions = ArrayHelper::merge([
            'useCurrent' => true,
            'locale' => $this->locale ?: substr(Yii::$app->language, 0, 2),
            'format' => $this->momentDatetimeFormat,
        ], $this->clientOptions);

        // Init default options
        $this->options = ArrayHelper::merge([
            'class' => 'form-control',
        ], $this->options);

        if ($value !== null) {
            $this->options['value'] = array_key_exists('value', $this->options)
                ? $this->options['value']
                : Yii::$app->formatter->asDatetime($value, $this->phpDatetimeFormat);
        }

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }

        $this->registerJs();
    }

    protected function registerJs()
    {
        DateTimeAsset::register($this->getView());
        $clientOptions = Json::encode($this->clientOptions);
        $this->getView()->registerJs("$('#{$this->containerOptions['id']}').datetimepicker({$clientOptions})");

        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#{$this->containerOptions['id']}').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $content = [];
        if ($this->showInputAddon) {
            Html::addCssClass($this->containerOptions, 'input-group');
        }
        Html::addCssStyle($this->containerOptions, 'position: relative');
        $content[] = Html::beginTag('div', $this->containerOptions);
        $content[] = $this->renderInput();

        if ($this->showInputAddon) {
            $content[] = $this->renderInputAddon();
        }

        $content[] = Html::endTag('div');
        return implode("\n", $content);
    }

    /**
     * @return string
     */
    protected function renderInput()
    {
        if ($this->hasModel()) {
            $content = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $content = Html::textInput($this->name, $this->value, $this->options);
        }
        return $content;
    }

    /**
     * @return string
     */
    protected function renderInputAddon()
    {
        $content = [];
        if (!array_key_exists('class', $this->inputAddonOptions)) {
            Html::addCssClass($this->inputAddonOptions, 'input-group-addon');
        }
        if (!array_key_exists('style', $this->inputAddonOptions)) {
            Html::addCssStyle($this->inputAddonOptions, ['cursor' => 'pointer']);
        }
        $content[] = Html::beginTag('span', $this->inputAddonOptions);
        if ($this->inputAddonContent) {
            $content[] = $this->inputAddonContent;
        } else {
            $content[] = Html::tag('span', '', ['class' => 'glyphicon glyphicon-calendar']);
        }
        $content[] = Html::endTag('span');

        return implode("\n", $content);
    }

    /**
     * @return array
     */
    protected function getPhpMomentMappings()
    {
        return array_merge($this->defaultPhpMomentMapping, $this->phpMomentMapping);
    }
}
