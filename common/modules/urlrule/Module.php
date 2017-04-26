<?php

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/6
 * Time: 下午9:50
 */
namespace common\modules\urlrule;

use yii\base\BootstrapInterface;
use common\modules\urlrule\models\UrlRule;
use Yii;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $rules = [];
        /**
         * @var UrlRule[] $models
         */
        $models = UrlRule::findOpenRules();
        foreach ($models as $model) {
            $params = [];
            parse_str($model->defaults, $params);
            $rules[] = [
                'pattern' => $model->pattern,
                'route' => $model->route,
                'suffix' => $model->suffix,
                'defaults' => $params,
                'verb' => $model->verb
            ];
        }
        if (isset($this->params['pretty']) && $this->params['pretty']) {
            Yii::$app->getUrlManager()->enablePrettyUrl = true;
            Yii::$app->getUrlManager()->showScriptName = false;
            Yii::$app->getUrlManager()->init();//目的是buildRule
            Yii::$app->getUrlManager()->addRules($rules, false);
        }

    }
}