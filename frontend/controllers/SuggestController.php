<?php
/**
 * author: yidashi
 * Date: 2015/12/21
 * Time: 11:37.
 */
namespace frontend\controllers;

use common\models\Comment;
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
            'query' => Comment::find()->where(['type' => 'suggest', 'parent_id' => 0]),
        ]);
        $model = new Comment();
        $model->type = 'suggest';
        $model->type_id = 1;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Comment();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', '感谢您的反馈！');
            return $this->redirect(['index']);
        } else {
            \Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
            return $this->redirect(['index']);
        }
    }
}
