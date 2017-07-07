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
use yii\web\NotFoundHttpException;

class SuggestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $query = Suggest::find()->orderBy('id desc');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Suggest();
        if ($model->load(request()->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '留言成功');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
    public function actionView($id)
    {
        $model = Suggest::findOne($id);
        if ($model == null) {
            throw new NotFoundHttpException('留言不存在');
        }
        return $this->render('view', [
           'model' => $model
        ]);
    }
}
