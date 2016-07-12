<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 上午11:18
 */

namespace common\widgets\area;


use yii\helpers\Html;
use common\models\Area as AreaModel;
use yii\widgets\InputWidget;

class Area extends InputWidget
{
    public $provinceAttribute;
    public $provinceName;
    public $provinceValue;
    public $cityAttribute;
    public $cityName;
    public $cityValue;
    public $areaAttribute;
    public $areaName;
    public $areaValue;
    public $required = false;
    /**
     * @var $fullArea string|array 地区合集 eg. 北京 北京市 东城区
     */
    public $fullArea;
    public $options = ['class' => 'form-group form-inline'];
    public $selectClass = 'form-control';
    public function init()
    {
        if (!empty($this->fullArea)) {
            list($this->provinceValue, $this->cityValue, $this->areaValue) = AreaModel::parseFullArea($this->fullArea);
        }
    }
    public function run()
    {
        AreaAsset::register($this->view);
        if ($this->hasModel()) {
            $provinceValue = Html::getAttributeValue($this->model, $this->provinceAttribute);
            $cityValue = Html::getAttributeValue($this->model, $this->cityAttribute);
            $select = Html::activeDropDownList($this->model, $this->provinceAttribute, AreaModel::getChildren(0), [
                'class' => $this->selectClass,
                'onChange' => 'getArea($(this).val())',
                'prompt' => '请选择'
            ]) . ' ' . Html::activeDropDownList($this->model, $this->cityAttribute, AreaModel::getChildren($provinceValue), [
                    'class' => $this->selectClass,
                    'onChange' => 'getArea($(this).val())',
                    'prompt' => '请选择'
                ]) . ' ' . Html::activeDropDownList($this->model, $this->areaAttribute, AreaModel::getChildren($cityValue), [
                    'class' => $this->selectClass,
                    'onChange' => 'getArea($(this).val())',
                    'prompt' => '请选择'
                ]);
        } else {
            $select = Html::dropDownList($this->provinceName, $this->provinceValue, AreaModel::getChildren(0), [
                    'class' => $this->selectClass,
                    'onChange' => 'getArea($(this).val())',
                    'prompt' => '请选择'
                ]) . ' ' . Html::dropDownList($this->cityName, $this->cityValue, AreaModel::getChildren($this->provinceValue), [
                    'class' => $this->selectClass,
                    'onChange' => 'getArea($(this).val())',
                    'prompt' => '请选择'
                ]) . ' ' . Html::dropDownList($this->areaName, $this->areaValue, AreaModel::getChildren($this->cityValue), [
                    'class' => $this->selectClass,
                    'prompt' => '请选择'
                ]);
        }
        return Html::tag('div', $select, $this->options);
    }
}