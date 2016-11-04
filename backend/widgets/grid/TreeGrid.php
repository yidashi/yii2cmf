<?php

namespace backend\widgets\grid;

use Closure;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\i18n\Formatter;

/**
 * TreeGrid renders a jQuery TreeGrid component.
 * The code was based in: https://github.com/yiisoft/yii2/blob/master/framework/grid/GridView.php
 *
 * @see https://github.com/maxazan/jquery-treegrid
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 */
class TreeGrid extends Widget
{
    /**
     * @var \yii\data\DataProviderInterface|\yii\data\BaseDataProvider the data provider for the view. This property is required.
     */
    public $dataProvider;

    /**
     * @var string the default data column class if the class name is not explicitly specified when configuring a data column.
     * Defaults to 'leandrogehlen\treegrid\TreeColumn'.
     */
    public $dataColumnClass;

    /**
     * @var array the HTML attributes for the container tag of the grid view.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'table table-striped table-bordered'];

    /**
     * @var array The plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array the HTML attributes for the table header row.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerRowOptions = [];
    /**
     * @var array the HTML attributes for the table footer row.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerRowOptions = [];

    /**
     * @var string the HTML display when the content of a cell is empty
     */
    public $emptyCell = '&nbsp;';

    /**
     * @var string the HTML content to be displayed when [[dataProvider]] does not have any data.
     */
    public $emptyText;

    /**
     * @var array the HTML attributes for the emptyText of the list view.
     * The "tag" element specifies the tag name of the emptyText element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $emptyTextOptions = ['class' => 'empty'];

    /**
     * @var boolean whether to show the header section of the grid table.
     */
    public $showHeader = true;
    /**
     * @var boolean whether to show the footer section of the grid table.
     */
    public $showFooter = false;
    /**
     * @var boolean whether to show the grid view if [[dataProvider]] returns no data.
     */
    public $showOnEmpty = true;

    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of [[Formatter]] or an configuration array for creating the [[Formatter]]
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter;

    /**
     * @var array|Closure the HTML attributes for the table body rows. This can be either an array
     * specifying the common HTML attributes for all body rows, or an anonymous function that
     * returns an array of the HTML attributes. The anonymous function will be called once for every
     * data model returned by [[dataProvider]]. It should have the following signature:
     *
     * ```php
     * function ($model, $key, $index, $grid)
     * ```
     *
     * - `$model`: the current data model being rendered
     * - `$key`: the key value associated with the current data model
     * - `$index`: the zero-based index of the data model in the model array returned by [[dataProvider]]
     * - `$grid`: the GridView object
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $rowOptions = [];

    /**
     * @var Closure an anonymous function that is called once BEFORE rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $beforeRow;

    /**
     * @var Closure an anonymous function that is called once AFTER rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $afterRow;

    /**
     * @var string name of key column used to build tree
     */
    public $keyColumnName;

    /**
     * @var string name of parent column used to build tree
     */
    public $parentColumnName;

    /**
     * @var mixed parent column value of root elements from data
     */
    public $parentRootValue = null;

    /**
     * @var array grid column configuration. Each array element represents the configuration
     * for one particular grid column.
     * @see \yii\grid::$columns for details.
     */
    public $columns = [];
    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate [[columns]] objects.
     */
    public function init()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException('The "dataProvider" property must be set.');
        }
        if ($this->emptyText === null) {
            $this->emptyText = Yii::t('yii', 'No results found.');
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if ($this->formatter == null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }
        if (!$this->formatter instanceof Formatter) {
            throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }

        if (!$this->keyColumnName) {
            throw new InvalidConfigException('The "keyColumnName" property must be specified"');
        }
        if (!$this->parentColumnName) {
            throw new InvalidConfigException('The "parentColumnName" property must be specified"');
        }

        $this->initColumns();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $id = $this->options['id'];
        $options = Json::htmlEncode($this->pluginOptions);

        $view = $this->getView();
        TreeGridAsset::register($view);

        $view->registerJs("jQuery('#$id').treegrid($options);");

        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $header = $this->showHeader ? $this->renderTableHeader() : false;
            $body = $this->renderItems();
            $footer = $this->showFooter ? $this->renderTableFooter() : false;

            $content = array_filter([
                $header,
                $body,
                $footer
            ]);

            return Html::tag('table', implode("\n", $content), $this->options);
        } else {
            return $this->renderEmpty();
        }
    }

    /**
     * Renders the HTML content indicating that the list view has no data.
     * @return string the rendering result
     * @see emptyText
     */
    public function renderEmpty()
    {
        $options = $this->emptyTextOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag($tag, ($this->emptyText === null ? Yii::t('yii', 'No results found.') : $this->emptyText), $options);
    }

    /**
     * Renders a table row with the given data model and key.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column TreeColumn */
        foreach ($this->columns as $column) {
            $cells[] = $column->renderDataCell($model, $key, $index);
        }
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;

        $id = ArrayHelper::getValue($model, $this->keyColumnName);
        Html::addCssClass($options, "treegrid-$id");

        $parentId = ArrayHelper::getValue($model, $this->parentColumnName);
        if ($parentId) {
            if(ArrayHelper::getValue($this->pluginOptions, 'initialState') == 'collapsed'){
                Html::addCssStyle($options, 'display: none;');
            }
            Html::addCssClass($options, "treegrid-parent-$parentId");
        }

        return Html::tag('tr', implode('', $cells), $options);
    }

    /**
     * Renders the table header.
     * @return string the rendering result.
     */
    public function renderTableHeader()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column TreeColumn */
            $cells[] = $column->renderHeaderCell();
        }
        $content = Html::tag('tr', implode('', $cells), $this->headerRowOptions);
        return "<thead>\n" . $content . "\n</thead>";
    }

    /**
     * Renders the table footer.
     * @return string the rendering result.
     */
    public function renderTableFooter()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column TreeColumn */
            $cells[] = $column->renderFooterCell();
        }
        $content = Html::tag('tr', implode('', $cells), $this->footerRowOptions);
        return "<tfoot>\n" . $content . "\n</tfoot>";
    }

    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $rows = [];
        $this->dataProvider->setKeys([]);
        $models = array_values($this->dataProvider->getModels());
        $models = $this->normalizeData($models, $this->parentRootValue);
        $this->dataProvider->setModels($models);
        $this->dataProvider->setKeys(null);
        $this->dataProvider->prepare();
        $keys = $this->dataProvider->getKeys();
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows)) {
            $colspan = count($this->columns);
            return "<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>";
        } else {
            return implode("\n", $rows);
        }
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                $column = Yii::createObject(array_merge([
                    'class' => $this->dataColumnClass ? : TreeColumn::className(),
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }

    /**
     * Creates a [[DataColumn]] object based on a string in the format of "attribute:format:label".
     * @param string $text the column specification string
     * @return DataColumn the column instance
     * @throws InvalidConfigException if the column specification is invalid
     */
    protected function createDataColumn($text)
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
        }

        return Yii::createObject([
            'class' => $this->dataColumnClass ? : TreeColumn::className(),
            'grid' => $this,
            'attribute' => $matches[1],
            'format' => isset($matches[3]) ? $matches[3] : 'text',
            'label' => isset($matches[5]) ? $matches[5] : null,
        ]);
    }

    /**
     * This function tries to guess the columns to show from the given data
     * if [[columns]] are not explicitly specified.
     */
    protected function guessColumns()
    {
        $models = $this->dataProvider->getModels();
        $model = reset($models);
        if (is_array($model) || is_object($model)) {
            foreach ($model as $name => $value) {
                $this->columns[] = $name;
            }
        }
    }

    /**
     * Normalize tree data
     * @param array $data
     * @param string $parentId
     * @return array
     */
    protected function normalizeData(array $data, $parentId = null) {
        $result = [];
        foreach ($data as $element) {
            if (ArrayHelper::getValue($element, $this->parentColumnName) === $parentId) {
                $result[] = $element;
                $children = $this->normalizeData($data, ArrayHelper::getValue($element, $this->keyColumnName));
                if ($children) {
                    $result = array_merge($result, $children);
                }
            }
        }
        return $result;
    }
} 
