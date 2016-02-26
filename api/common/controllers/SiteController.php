<?php

namespace api\common\controllers;

use common\logic\Article;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return Article::find()->limit(1)->one();
    }
}