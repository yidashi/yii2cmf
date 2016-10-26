<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 上午11:18
 */

namespace common\modules\city\widgets;


use common\models\City;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class CityWidget extends InputWidget
{
    public $provinceAttribute;
    public $provinceName;
    public $provinceValue;
    public $provincePrompt = '请选择';
    public $cityAttribute;
    public $cityName;
    public $cityValue;
    public $cityPrompt = '请选择';
    public $areaAttribute;
    public $areaName;
    public $areaValue;
    public $areaPrompt = '请选择';

    public $required = false;

    public $route = ['/city/default/children'];
    /**
     * @var $fullArea string|array 地区合集 eg. 北京 北京市 东城区
     */
    public $fullArea;
    public $defaultOptions = ['id' => 'city-three-level-link', 'class' => 'form-group form-inline'];
    public $selectClass = 'form-control';
    public $clientOptions = [];
    public function init()
    {
        $this->options = array_merge($this->defaultOptions, $this->options);
        if (!isset($this->options['id'])) {
            throw new InvalidConfigException('{options}.id必须设置');
        }
        parent::init();
        if (!empty($this->fullArea)) {
            list($this->provinceValue, $this->cityValue, $this->areaValue) = City::parseFullArea($this->fullArea);
        }
    }
    public function run()
    {
        $this->registerClientJs();
        if ($this->hasModel()) {
            $provinceValue = Html::getAttributeValue($this->model, $this->provinceAttribute);
            $cityValue = Html::getAttributeValue($this->model, $this->cityAttribute);
            $select = Html::activeDropDownList($this->model, $this->provinceAttribute, City::getChildren(0), [
                'class' => $this->selectClass,
                'prompt' => $this->provincePrompt
            ]) . ' ' . Html::activeDropDownList($this->model, $this->cityAttribute, City::getChildren($provinceValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->cityPrompt
                ]) . ' ' . Html::activeDropDownList($this->model, $this->areaAttribute, City::getChildren($cityValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->areaPrompt
                ]);
        } else {
            $select = Html::dropDownList($this->provinceName, $this->provinceValue, City::getChildren(0), [
                    'class' => $this->selectClass,
                    'prompt' => $this->provincePrompt
                ]) . ' ' . Html::dropDownList($this->cityName, $this->cityValue, City::getChildren($this->provinceValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->cityPrompt
                ]) . ' ' . Html::dropDownList($this->areaName, $this->areaValue, City::getChildren($this->cityValue), [
                    'class' => $this->selectClass,
                    'prompt' => $this->areaPrompt
                ]);
        }

        return Html::tag('div', $select, $this->options);
    }
    public function registerClientJs()
    {
        CityAsset::register($this->view);
        $this->clientOptions['url'] = Url::to($this->route);
        $clientOptions = Json::htmlEncode($this->clientOptions);
        $this->view->registerJs("$('#{$this->options['id']} select').getArea($clientOptions)");
    }
}