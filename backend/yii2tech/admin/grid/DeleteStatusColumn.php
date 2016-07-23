<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\grid;

use Yii;
use yii\base\Model;
use yii\grid\DataColumn;
use yii\helpers\Html;

/**
 * DeleteStatusColumn is a special version of [[DataColumn]] dedicated to display of 'soft-delete' indicator columns.
 * This column can be useful in case you are using 'soft-delete' feature for the records displayed in the grid,
 * which hides 'deleted' records by default, but still provides access to them on particular filter value.
 *
 * The main feature of this class is a filter cell rendering: it sets drop-down prompt to be more verbose and
 * adds an extra item for 'all records' display to the end of the list. If no filter provided - its options will be
 * composed automatically.
 *
 * Note: remember to handle value correctly inside the filter model, so empty value should hide 'deleted' records,
 * while [[filterAllValue]] should display all records. For example:
 *
 * ```php
 * class ItemSearch extends \yii\base\Model
 * {
 *     public function search()
 *     {
 *         $query = Item::find();
 *
 *         if (empty($this->statusId)) {
 *             // filter is not set - display only actual records :
 *             $query->andWhere(['not', ['statusId' => Item::STATUS_DELETED]]);
 *         } elseif($this->statusId > 0) {
 *             // 'show all' is not selected - apply filter :
 *             $query->andFilterWhere(['statusId' => $this->statusId]);
 *         }
 *
 *         // ...
 *     }
 * }
 * ```
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class DeleteStatusColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public $format = null;
    /**
     * @var mixed value, which indicates 'show all records' entry in the filter drop down.
     */
    public $filterAllValue = '-1';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->format === null) {
            if (stripos($this->attribute, 'deleted') !== false || stripos($this->attribute, 'active') !== false) {
                $this->format = 'boolean';
            } else {
                $this->format = 'text';
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $filterItems = $this->filter;
                $filterItems[$this->filterAllValue] = Yii::t('yii2tech-admin', 'All records');
            } else {
                $filterItems = [
                    '0' => Yii::t('yii2tech-admin', 'Deleted'),
                    $this->filterAllValue => Yii::t('yii2tech-admin', 'All records')
                ];
            }
            $options = array_merge(['prompt' => Yii::t('yii2tech-admin', 'Actual only')], $this->filterInputOptions);
            return Html::activeDropDownList($model, $this->attribute, $filterItems, $options) . $error;
        } else {
            return parent::renderFilterCellContent();
        }
    }
}