<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午4:22
 */

namespace common\helpers;


use yii\helpers\ArrayHelper;

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

    public static function getEntityList()
    {
        return [
            'common\models\Suggest' => '留言',
            'common\models\Page' => '单页',
            'common\models\Article' => '文章',
            'common\modules\book\models\Book' => '书',
            'common\modules\book\models\BookChapter' => '书章节',
        ];
    }
    public static function getEntityName($entity)
    {
        $entityList = self::getEntityList();
        return ArrayHelper::getValue($entityList, $entity, $entity);
    }
}