<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020-04-08
 * Time: 22:45
 */

namespace common\services;

use common\helpers\Util;
use common\models\Nav;
use common\models\NavItem;
use Yii;

class NavService
{
    public static function getItems($key)
    {
        $cacheKey = 'nav_' . $key;
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $nav = Nav::find()->where(['key' => $key])->one();
            if ($nav == null) {
                return [];
            }
            $items = NavItem::find()->select('title label, url, target')
                ->where(['nav_id' => $nav->id, 'status' => 1])
                ->orderBy(['order' => SORT_ASC])
                ->asArray()->all();
            $items = array_map(function ($value) {
                $value['url'] = Util::parseUrl($value['url']);
                if ($value['target'] == 1) {
                    $value['linkOptions'] = ['target' => '_blank'];
                }
                return $value;
            }, $items);
            Yii::$app->cache->set($cacheKey, $items, 60 * 60 * 24);
        }
        return $items;
    }
}
