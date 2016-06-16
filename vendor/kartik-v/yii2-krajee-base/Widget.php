<?php

/**
 * @package   yii2-krajee-base
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   1.8.5
 */

namespace kartik\base;

use Yii;

/**
 * Base widget class for Krajee extensions
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class Widget extends \yii\base\Widget
{
    use TranslationTrait;
    use WidgetTrait;

    /**
     * @var array HTML attributes or other settings for widgets
     */
    public $options = [];

    /**
     * @var string the javascript that will be used to destroy the jQuery plugin
     */
    public $pluginDestroyJs;

    /**
     * @var array widget plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in event-name => event-function format for example:
     * ~~~
     * pluginEvents = [
     *     "change" => "function() { log("change"); }",
     *     "open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var string the name of the jQuery plugin
     */
    public $pluginName = '';

    /**
     * @var string a pjax container identifier if applicable inside which the widget will be rendered. If this is set,
     *     the widget will automatically reinitialize on pjax completion.
     */
    public $pjaxContainerId;

    /**
     * @var bool enable pop state fix for pjax container on press of browser back & forward buttons
     */
    public $enablePopStateFix = true;

    /**
     * @var array the the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @var string translation message file category name for i18n
     */
    protected $_msgCat = '';

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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->initDestroyJs();
    }
}
