<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/2
 * Time: 下午2:07
 */

namespace api\common\controllers;

use yii\filters\Cors;

class Controller extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['contentNegotiator']['formats']['application/xml']);
        $behaviors['cors'] = [
            'class' => Cors::className(),
            'cors' => [
                'Access-Control-Expose-Headers' => ['Set-Cookie']
            ]
        ];
        return $behaviors;
    }
}