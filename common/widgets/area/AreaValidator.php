<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/12
 * Time: 下午1:54
 */

namespace common\widgets\area;


use yii\validators\Validator;

class AreaValidator extends Validator
{
    public $provinceAttribute = 'province';
    public $cityAttribute = 'city';
    public $areaAttribute = 'area';
    public $validator;
    public function init()
    {
        parent::init();
        $this->message = '省市区不能为空';
    }

    public function validateAttribute($model, $attribute)
    {
        $provinceValue = $model->{$this->provinceAttribute};
        $cityValue = $model->{$this->cityAttribute};
        $areaValue = $model->{$this->areaAttribute};
        if ($this->isEmpty($provinceValue) || $this->isEmpty($cityValue) || $this->isEmpty($areaValue)) {
            $model->addError($attribute, $this->message);
        }
    }
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message);
        return <<<JS
if (!value) {
    messages.push($message);
}
JS;
    }
}