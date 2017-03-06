<?php

namespace common\modules\urlrule\components;

use Yii;

class UrlRule extends \yii\web\UrlRule
{

    /**
     * @inheritdoc
     */
    public function init()
    {}

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param string $route            
     * @param array $params            
     * @return bool|mixed
     */
    public function createUrl($manager, $route, $params)
    {
        $rule = $this->getRuleByRoute($route, $params);
        
        if ($rule) {
            return $rule->pattern;
        }
        
        return false;
    }

    public function getRuleByRoute($route, $params)
    {
        $ruleCache = \Yii::$app->getCache()->get(UrlRule::className());
        if ($ruleCache == null) {
            $ruleCache = [];
        }
        
        $params = (array) $params;
        
        $cacheKey = $route . '?' . serialize($params);
        
        if (isset($ruleCache[$cacheKey])) {
            return $ruleCache[$cacheKey];
        }

        $rule = \common\modules\urlrule\models\UrlRule::getRuleByRoute($route, $params);
        if (! $rule) {
            return null;
        }
        
        $ruleCache[$cacheKey] = $rule;        
        \Yii::$app->getCache()->set(UrlRule::className(), $ruleCache);
        
        return $rule;
    }

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param \yii\web\Request $request            
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $rule = $this->getRuleByPattern($request->getPathInfo());
        if ($rule) {
            $params = [];
            parse_str($rule->defaults, $params);
            return [
                $rule->route,
                $params
            ];
        }
        
        return false;
    }
    
    
    public function getRuleByPattern($pattern)
    {
        $ruleCache = \Yii::$app->getCache()->get(UrlRule::className());
        if ($ruleCache == null) {
            $ruleCache = [];
        }
        
        $cacheKey = $pattern;
        
        if (isset($ruleCache[$cacheKey])) {
            return $ruleCache[$cacheKey];
        }
        
        $rule = \common\modules\urlrule\models\UrlRule::getRuleByPattern($pattern);
        if (! $rule) {
            return null;
        }
        
        $ruleCache[$cacheKey] = $rule;
        \Yii::$app->getCache()->set(UrlRule::className(), $ruleCache);
        
        return $rule;
    }
}