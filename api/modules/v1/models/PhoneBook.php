<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/4/15
 * Time: 上午11:35
 */

namespace api\modules\v1\models;


use yii\helpers\Url;

class PhoneBook extends \common\models\PhoneBook
{

    public function fields()
    {
        return [
            'id',
            'true_name',
            'nick_name',
            'avatar' => function ($model) {
                return Url::to($model->getAvatar(), true);
            },
            'phone',
            'wechat_nick_name',
            'wechat_avatar'
        ];
    }
}