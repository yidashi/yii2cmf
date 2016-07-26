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
    /**
     * 解析url 格式: route[空格,回车]a=1&b=2
     * @param $url
     * @return array
     */
    public static function parseUrl($url)
    {
        if (strpos($url, '//') !== false) {
            return $url;
        }
        // 空格换行都行
        $url = preg_split('/[ \r\n]+/', $url);
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