<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午11:24
 */

namespace frontend\controllers;


use yii\web\Controller;
use Yii;

class NoticeController extends Controller
{
    /**
     * @var \frontend\components\Notify
     */
    public $message;

    public function init()
    {
        $this->message = Yii::$app->notify;
    }
    public function actionIndex()
    {
        $this->message->readAll();
        $dataProvider = $this->message->getDataProvider();
        return $this->render('index', [
           'dataProvider' => $dataProvider
        ]);
    }
}