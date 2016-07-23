<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/23
 * Time: 下午9:13
 */

namespace common\behaviors;


use common\models\Profile;
use common\models\User;
use yii\base\Behavior;

/**
 * 方便替换
 * Class UserBehavior
 * @package common\behaviors
 */
class UserBehavior extends Behavior
{
    public $userIdAttribute = 'user_id';
    public function getUser()
    {
        return $this->owner->hasOne(User::className(), ['id' => $this->userIdAttribute]);
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => $this->userIdAttribute]);
    }
}