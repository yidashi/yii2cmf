<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/23
 * Time: 下午5:41
 */

namespace frontend\controllers;


use frontend\models\Tag;
use yii\web\Controller;

class TagController extends Controller
{
    public function actions()
    {
        return [
            'search' => 'common\\actions\\TagSearchAction'
        ];
    }

    public function actionIndex()
    {
        $hotModels = Tag::hot();
        $models = Tag::find()->all();
        return $this->render('index', [
            'models' => $models,
            'hotModels' => $hotModels
        ]);
    }
}