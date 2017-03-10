<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/9 13:06
 * Description:
 */

namespace api\modules\v1\models\article;


class Photo extends \common\models\article\Photo
{
    public function fields()
    {
        return [
            'photos',
            'photos_total' => function ($model) {
                return count($model->photos);
            }
        ];
    }
}