<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/24
 * Time: 下午2:40
 */

namespace api\common\behaviors;


use yii\base\Behavior;
use yii\base\DynamicModel;
use yii\validators\Validator;
use yii\base\InvalidConfigException;

class ValidateBehavior extends Behavior
{

    public function validate($data, $rules)
    {
        $_attributes = [];
        foreach ($rules as $rule) {
            if (is_array($rule[0])) {
                $_attributes = array_merge($_attributes, $rule[0]);
            } else {
                $_attributes[] = $rule[0];
            }
        }
        $model = new DynamicModel($_attributes);
        if (!empty($rules)) {
            $validators = $model->getValidators();
            foreach ($rules as $rule) {
                if ($rule instanceof Validator) {
                    $validators->append($rule);
                } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                    $validator = Validator::createValidator($rule[1], $model, (array) $rule[0], array_slice($rule, 2));
                    $validators->append($validator);
                } else {
                    throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
                }
            }
        }
        $model->attributes = $data;
        $model->validate();
        return $model;
    }
}