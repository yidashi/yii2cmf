<?php
/**
 * author: yidashi
 * Date: 2015/12/24
 * Time: 16:13
 */

namespace frontend\controllers;


use yii\web\Controller;

class PageController extends Controller
{
    public $layout = false;
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\web\ViewAction',
            ],
        ];
    }
} 