<?php
namespace common\modules\urlrule\controllers;

use common\components\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actions()
    {
        return [
            "delete" => 'backend\actions\Delete'
        ];
    }

    public function actionIndex()
    {
        $query = \common\modules\urlrule\models\UrlRule::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $model = new \common\modules\urlrule\models\UrlRule();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new \common\modules\urlrule\models\UrlRule();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return \common\modules\urlrule\models\UrlRule the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = \common\modules\urlrule\models\UrlRule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
