<?php

/**
 * @package   yii2-krajee-base
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version   1.7.7
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
     * @var array widget plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *     "change" => "function() { log("change"); }",
     *     "open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var array the the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @var string translation message file category name for i18n
     */
    protected $_msgCat = '';

    /**
     * @var string the name of the jQuery plugin
     */
    protected $_pluginName;

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
    }
}
