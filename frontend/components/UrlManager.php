<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/6
 * Time: 下午11:56
 */

namespace frontend\components;

use common\modules\urlrule\components\UrlRule;


class UrlManager extends \yii\web\UrlManager
{
    private $_baseUrl;
    private $_scriptUrl;
    private $_hostInfo;
    private $_ruleCache;

    const EVENT_CREATE_PARAMS = "EVENT_CREATE_PARAMS";

    const EVENT_INIT_RULECACHE = "EVENT_INIT_RULECACHE";

    public function init()
    {
        parent::init();
        $event = new UrlRuleCacheEvent(['ruleCache' => $this->_ruleCache, 'urlManager' => $this]);
        $this->trigger(static::EVENT_INIT_RULECACHE,$event);
        $this->_ruleCache = $event->ruleCache;
    }

    public function createUrl($params)
    {

        $params = (array) $params;
        $anchor = isset($params['#']) ? '#' . $params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);

        $route = trim($params[0], '/');
        unset($params[0]);

        $event = new UrlParamsEvent(["urlParams"=>$params]);
        $this->trigger(static::EVENT_CREATE_PARAMS,$event);
        $params = $event->urlParams;

        $baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();

        if ($this->enablePrettyUrl) {
            $cacheKey = $route . '?' . implode('&', array_keys($params));

            /* @var $rule UrlRule */
            $url = false;
            if (isset($this->_ruleCache[$cacheKey])) {
                foreach ($this->_ruleCache[$cacheKey] as $rule) {
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        break;
                    }
                }
            } else {
                $this->_ruleCache[$cacheKey] = [];
            }

            if ($url === false) {
                $cacheable = true;
                foreach ($this->rules as $rule) {
                    if (!empty($rule->defaults) && $rule->mode !== UrlRule::PARSING_ONLY) {
                        // if there is a rule with default values involved, the matching result may not be cached
                        $cacheable = false;
                    }
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        if ($cacheable) {
                            $this->_ruleCache[$cacheKey][] = $rule;
                        }
                        break;
                    }
                }
            }

            if ($url !== false) {
                if (strpos($url, '://') !== false) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 8)) !== false) {
                        return substr($url, 0, $pos) . $baseUrl . substr($url, $pos) . $anchor;
                    } else {
                        return $url . $baseUrl . $anchor;
                    }
                } else {
                    return "$baseUrl/{$url}{$anchor}";
                }
            }

            if ($this->suffix !== null) {
                $route .= $this->suffix;
            }
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $route .= '?' . $query;
            }

            return "$baseUrl/{$route}{$anchor}";
        } else {
            $url = "$baseUrl?{$this->routeParam}=" . urlencode($route);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '&' . $query;
            }

            return $url . $anchor;
        }
    }
}