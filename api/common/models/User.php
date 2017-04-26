<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/3/8 16:32
 * Description:
 */

namespace api\common\models;


use common\models\Friend;
use yii\helpers\Url;

class User extends \common\modules\user\models\User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'access_token',
            'expired_at',
            'avatar' => function ($model) {
                return Url::to($model->getAvatar(), true);
            }
        ];
    }

    public function extraFields()
    {
        return [
            'profile',
            'friend' => function ($model) {
                return [
                    'follow_num' => Friend::getFollowNumber($model->id),
                    'fans_num' => Friend::getFansNumber($model->id)
                ];
            }
        ];
    }
}