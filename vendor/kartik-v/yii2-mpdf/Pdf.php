<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-mpdf
 * @version 1.0.0
 */

namespace kartik\mpdf;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use \mPDF;

/**
 * PDF library component wrapping the mPDF class with additional enhancements.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Pdf extends Component
{
    // mode
    const MODE_BLANK = '';
    const MODE_CORE = 'c';
    const MODE_UTF8 = 'utf-8';

    // format
    const FORMAT_A3 = 'A3';
    const FORMAT_A4 = 'A4';
    const FORMAT_LETTER = 'Letter';
    const FORMAT_LEGAL = 'Legal';
    const FORMAT_FOLIO = 'Folio';
    const FORMAT_LEDGER = 'Ledger-L';
    const FORMAT_TABLOID = 'Tabloid';

    // orientation
    const ORIENT_PORTRAIT = 'P';
    const ORIENT_LANDSCAPE = 'L';

    // output destination
    const DEST_BROWSER = 'I';
    const DEST_DOWNLOAD = 'D';
    const DEST_FILE = 'F';
    const DEST_STRING = 'S';

    /**
     * @var string specifies the mode of the new document. If the mode is set by passing a country/language string,
     * this may also set: available fonts, text justification, and directionality RTL.
     */
    public $mode = self::MODE_BLANK;

    /**
     * @var string|array, the format can be specified either as a pre-defined page size,
     * or as an array of width and height in millimetres.
     */
    public $format = self::FORMAT_A4;

    /**
     * @var int sets the default document font size in points (pt)
     */
    public $defaultFontSize = 0;

    /**
     * @var string sets the default font-family for the new document. Uses default value set in defaultCSS
     * unless codepage has been set to "win-1252". If codepage="win-1252", the appropriate core Adobe font
     * will be set i.e. Helvetica, Times, or Courier.
     */
    public $defaultFont = '';

    /**
     * @var float sets the page left margin for the new document. All values should be specified as LENGTH in millimetres.
     * If you are creating a DOUBLE-SIDED document, the margin values specified will be used for ODD pages; left and right margins
     * will be mirrored for EVEN pages.
     */
    public $marginLeft = 15;

    /**
     * @var float sets the page right margin for the new document (in millimetres).
     */
    public $marginRight = 15;

    /**
     * @var float sets the page top margin for the new document (in millimetres).
     */
    public $marginTop = 16;

    /**
     * @var float sets the page bottom margin for the new document (in millimetres).
     */
    public $marginBottom = 16;

    /**
     * @var float sets the page header margin for the new document (in millimetres).
     */
    public $marginHeader = 9;

    /**
     * @var float sets the page footer margin for the new document (in millimetres).
     */
    public $marginFooter = 9;

    /**
     * @var string specifies the default page orientation of the new document.
     */
    public $orientation = self::ORIENT_PORTRAIT;

    /**
     * @var string css file to prepend to the PDF
     */
    public $cssFile = '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css';

    /**
     * @var string additional inline css to append after the cssFile
     */
    public $cssInline = '';

    /**
     * @var string the HTML content to be converted to PDF
     */
    public $content = '';

    /**
     * @var string the output filename
     */
    public $filename = '';

    /**
     * @var string the output destination
     */
    public $destination = self::DEST_BROWSER;

    /**
     * @var array the mPDF methods that will called in the sequence listed before
     * rendering the content. Should be an associative array of $method => $params
     * format, where:
     * - `$method`: string, is the mPDF method / function name
     * - `$param`: mixed, are the mPDF method parameters
     */
    public $methods = '';

    /**
     * @var string the mPDF configuration options entered as a `$key => value`
     * associative array, where:
     * - `$key`: string is the mPDF configuration property name
     * - `$value`: mixed is the mPDF configured property value
     */
    public $options = [];

    /**
     * @var mPDF api instance
     */
    protected $_mpdf;

    /**
     * @var string the css file content
     */
    protected $_css;

    /**
     * @inherit doc
     */
    public function init()
    {
        parent::init();
        $this->parseFormat();
    }

    /**
     * Renders and returns the PDF output. Uses the class level property settings.
     */
    public function render()
    {
        $this->configure($this->options);
        if (!empty($this->methods)) {
            foreach ($this->methods as $method => $param) {
                $this->execute($method, $param);
            }
        }
        return $this->output($this->content, $this->filename, $this->destination);
    }

    /**
     * Initializes (if needed) and fetches the mPDF API instance
     * @return mPDF instance
     */
    public function getApi()
    {
        if (empty($this->_mpdf) || !$this->_mpdf instanceof mPDF) {
            $this->setApi();
        }
        return $this->_mpdf;
    }

    /**
     * Sets the mPDF API instance
     */
    public function setApi()
    {
        $this->_mpdf = new mPDF(
            $this->mode,
            $this->format,
            $this->defaultFontSize,
            $this->defaultFont,
            $this->marginLeft,
            $this->marginRight,
            $this->marginTop,
            $this->marginBottom,
            $this->marginHeader,
            $this->marginFooter,
            $this->orientation
        );
    }

    /**
     * Fetches the content of the CSS file if supplied
     * @return string
     */
    public function getCss()
    {
        if (!empty($this->_css)) {
            return $this->_css;
        }
        $cssFile = empty($this->cssFile) ? '' : Yii::getAlias($this->cssFile);
        if (empty($cssFile) || !file_exists($cssFile)) {
            $css = '';
        } else {
            $css = file_get_contents($cssFile);
        }
        $css .= $this->cssInline;
        return $css;
    }

    /**
     * Configures mPDF options
     * @param array the mPDF configuration options entered as a `$key => value`
     * associative array, where:
     * - `$key`: string is the configuration property name
     * - `$value`: mixed is the configured property value
     */
    public function configure($options = [])
    {
        if (empty($options)) {
            return;
        }
        $api = $this->api;
        foreach ($options as $key => $value) {
            if (property_exists($api, $key)) {
                $api->$key = $value;
            }
        }
    }

    /**
     * Calls the mPDF method with parameters
     * @param string method the mPDF method / function name
     * @param array params the mPDF parameters
     * @return mixed
     */
    public function execute($method, $params = [])
    {
        $api = $this->api;
        if (!method_exists($api, $method)) {
            throw new InvalidParamException("Invalid or undefined mPDF method '{$method}' passed to 'Pdf::execute'.");
        }
        if (!is_array($params)) {
            $params = [$params];
        }
        return call_user_func_array([$api, $method], $params);
    }

    /**
     * Generates a PDF output
     * @param string content, the input HTML content
     * @param string file, the name of the file. If not specified, the document will be
     * sent to the browser inline (destination I).
     * @param string dest, the destination. Defaults to Pdf::DEST_INLINE.
     * @return mixed
     */
    public function output($content = '', $file = '', $dest = self::DEST_INLINE)
    {
        $api = $this->api;
        $css = $this->css;
        if (!empty($css)) {
            $api->WriteHTML($css, 1);
            $api->WriteHTML($content, 2);
        } else {
            $api->WriteHTML($content);
        }
        return $api->Output($file, $dest);
    }

    /**
     * Parse the format automatically based on the orientation
     */
    protected function parseFormat()
    {
        $tag = '-' . self::ORIENT_LANDSCAPE;
        if ($this->orientation == self::ORIENT_LANDSCAPE && is_string($this->format) && substr($this->format,
                -2) != $tag
        ) {
            $this->format .= $tag;
        }
    }

}