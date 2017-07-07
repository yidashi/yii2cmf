<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/11
 * Time: 下午7:14
 */

namespace plugins\locale\controllers;


use plugins\locale\SetLocaleAction;
use yii\web\Controller;
use Yii;
use yii\base\InvalidParamException;
use yii\web\Cookie;

class DefaultController extends Controller
{
    public $config;

    public function actions()
    {
        return [
            'set' => [
                'class' => SetLocaleAction::className(),
                'locales' => $this->config['availableLocales']
            ],

        ];
    }
}