<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午4:22
 */

namespace common\helpers;


class Util
{
    public static function parseUrl($url)
    {
        $url = explode("\r\n", $url);
        if (isset($url[1])) {
            $tmp = $url[1];
            unset($url[1]);
            $tmpParams = explode('&', $tmp);
            $params = [];
            foreach ($tmpParams as $tmpParam) {
                list($key, $value) = explode('=', $tmpParam);
                $params[$key] = $value;
            }
            $url = array_merge($url, $params);
        }
        return $url;
    }
}