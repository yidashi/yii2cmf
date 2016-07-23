<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\grid;

use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\grid\DataColumn;

/**
 * VariationColumn supports rendering of the model variation attribute, provided by [yii2tech/ar-variation](https://github.com/yii2tech/ar-variation).
 *
 * @see https://github.com/yii2tech/ar-variation
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class VariationColumn extends DataColumn
{
    /**
     * @var string name of the variation model attribute.
     * If not set [[attribute]] value will be used.
     */
    public $variationAttribute;
    /**
     * @var string|callable variation label source. This should be either a string -  variation option
     * model attribute, which value should be used as variation label, or a callback of following signature:
     *
     * ```php
     * function ($mainModel, $variationModel) {
     *     // return string label
     * }
     * ```
     */
    public $variationLabel;
    /**
     * @var array the HTML attributes for the variation table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table table-bordered table-condensed', 'style' => 'margin-bottom:0px;'];

    /**
     * @var array internal cache for variation labels.
     */
    private $_variationLabels;


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null) {
            $contentParts = [];
            foreach ($model->getVariationModels() as $variationModel) {
                $contentParts[] = '<tr><td><b>' . $this->getVariationLabel($model, $variationModel) . '</b></td><td>' . $this->getVariationValue($variationModel) . '</td>';
            }
            return Html::tag('table', implode("\n", $contentParts), $this->tableOptions);
        } else {
            return parent::renderDataCellContent($model, $key, $index);
        }
    }

    /**
     * Returns the variation value.
     * @param \yii\base\Model $variationModel variation model instance.
     * @return string value.
     */
    protected function getVariationValue($variationModel)
    {
        $attribute = $this->variationAttribute === null ? $this->attribute : $this->variationAttribute;
        return $this->grid->formatter->format($variationModel->{$attribute}, $this->format);
    }

    /**
     * Returns the variation label.
     * @param \yii\base\Model|\yii2tech\ar\variation\VariationBehavior $mainModel main model instance.
     * @param \yii\base\Model $variationModel variation model instance.
     * @return string label.
     * @throws InvalidConfigException on empty [[variationLabel]] value.
     */
    protected function getVariationLabel($mainModel, $variationModel)
    {
        if (empty($this->variationLabel)) {
            throw new InvalidConfigException('"' . get_class($this) . '::variationLabel" must be specified');
        }
        if (!is_string($this->variationLabel)) {
            return call_user_func($this->variationLabel, $mainModel, $variationModel);
        }

        $variationLabels = $this->getVariationLabels($mainModel, $this->variationLabel);

        $referenceAttribute = $mainModel->variationOptionReferenceAttribute;
        $variationPk = $variationModel->$referenceAttribute;

        if (isset($variationLabels[$variationPk])) {
            return $variationLabels[$variationPk];
        }

        return $variationModel->$referenceAttribute;
    }

    /**
     * Returns all available variation labels.
     * @param \yii\base\Model|\yii2tech\ar\variation\VariationBehavior $mainModel main model instance.
     * @param string $labelAttribute name of the attribute, which is used as label source.
     * @return array list labels in format: optionPk => label
     */
    protected function getVariationLabels($mainModel, $labelAttribute)
    {
        if (!isset($this->_variationLabels[$labelAttribute])) {
            /* @var $optionClass \yii\db\ActiveRecordInterface */
            $optionClass = $mainModel->optionModelClass;
            foreach ($optionClass::find()->all() as $optionModel) {
                /* @var $optionModel \yii\db\ActiveRecordInterface */
                $this->_variationLabels[$labelAttribute][$optionModel->getPrimaryKey()] = $optionModel->$labelAttribute;
            }
        }
        return $this->_variationLabels[$labelAttribute];
    }
}