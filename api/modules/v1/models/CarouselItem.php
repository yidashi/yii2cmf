<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/4/14
 * Time: 下午11:33
 */

namespace api\modules\v1\models;


class CarouselItem extends \common\models\CarouselItem
{
    public function fields()
    {
        return [
            'url',
            'image' => function ($model) {
                return $model->image->url;
            }
        ];
    }
}