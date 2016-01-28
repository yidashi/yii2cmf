<?php

namespace api\common\controllers;

use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return [
            'code' => 1,
            'msg' => 'success'
        ];
    }
}