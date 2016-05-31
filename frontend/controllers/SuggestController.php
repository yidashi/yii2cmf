<?php
/**
 * author: yidashi
 * Date: 2015/12/21
 * Time: 11:37.
 */
namespace frontend\controllers;

use common\models\Suggest;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class SuggestController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Suggest::find()
        ]);
        $model = new Suggest();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Suggest();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '感谢您的反馈！');

            return $this->redirect(['index']);
        }
    }
}
