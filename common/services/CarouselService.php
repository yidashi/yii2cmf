<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/4/19
 * Time: 10:37 上午
 */

namespace common\services;

use common\models\Carousel as CarouselModel;
use common\models\CarouselItem;
use Yii;

class CarouselService
{
    /**
     * @param $key
     * @return array|mixed|CarouselItem[]
     */
    public function findByKey($key)
    {
        $cacheKey = [
            CarouselModel::className(),
            $key
        ];
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = CarouselItem::find()
                ->joinWith('carousel')
                ->where([
                    '{{%carousel_item}}.status' => 1,
                    '{{%carousel}}.status' => CarouselModel::STATUS_ACTIVE,
                    '{{%carousel}}.key' => $key,
                ])
                ->orderBy(['sort' => SORT_ASC])
                ->asArray()
                ->all();
//            p($items);
            Yii::$app->cache->set($cacheKey, $items, 60 * 60 * 24);
        }
        return $items;
    }
}
