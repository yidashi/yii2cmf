<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/17
 * Time: 下午9:41
 */

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        return $value;
    }
}

if (! function_exists('url')) {

    function url($url, $scheme = false)
    {
        return \yii\helpers\Url::to($url, $scheme);
    }
}
if (! function_exists('array_get')) {

    /**
     * 通过foo.bar方式获取多维数组的值
     * ```
     * $arr = ['a' => 1. 'b' => ['c' => 2, 'd' => 3]];
     * echo array_get($arr, b.d);
     * ```
     * 输出3
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return \yii\helpers\ArrayHelper::getValue($array, $key, $default);
    }
}

if (! function_exists('p')) {

    function p($var, $die = true)
    {
        echo '<pre>' . print_r($var, true), '</pre>';
        if ($die) {
            die;
        }
    }
}

if (! function_exists('config')) {
    /**
     * `config()`获取config组件
     * `config('key')` 获取配置key的值
     * `config([key,value])` 设置配置key的值为value
     * @param null $key
     * @param null $default
     * @return array|bool|\config\components\Config|mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return Yii::$app->config;
        }

        if (is_array($key)) {
            return Yii::$app->config->set($key[0], $key[1]);
        }

        return Yii::$app->config->get($key, $default);
    }
}

if (! function_exists('request')) {

    function request($name = null, $defaultValue = null)
    {
        if (is_null($name)) {
            return Yii::$app->request;
        }

        $params = Yii::$app->request->getQueryParams() + Yii::$app->request->getBodyParams();

        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }
}