<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/2
 * Time: 下午2:07
 */

namespace api\modules\v1\controllers;


class Controller extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;

    }
}