<?php
/**
 * author: yidashi
 * Date: 2015/12/21
 * Time: 11:37.
 */
namespace frontend\controllers;

use common\models\Comment;
use common\models\Suggest;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class SuggestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
