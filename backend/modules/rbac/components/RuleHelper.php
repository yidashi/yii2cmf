<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/28
 * Time: 上午11:14
 */

namespace backend\modules\rbac\components;

use Yii;

class RuleHelper
{
    public static function enums()
    {
        $ruleModels = Yii::$app->authManager->getRules();
        $rules = array_keys($ruleModels);
        return array_combine($rules, $rules);
    }
}