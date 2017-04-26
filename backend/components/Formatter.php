<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2016/10/20 11:49
 * Description:
 */

namespace backend\components;


use common\modules\user\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Formatter extends \yii\i18n\Formatter
{
    public function asAdmin($value)
    {
        return ArrayHelper::getValue(User::findOne($value), 'username', '');
    }

    public function asColor($value, $color = 'default')
    {
        if ($color instanceof \Closure) {
            $color = call_user_func($color, $value);
        }
        return Html::tag('span', $value, ['class' => 'text-' . $color]);
    }
}