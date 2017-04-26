<?php

namespace backend\controllers;

use common\models\Nav;
use common\models\NavItem;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * NavItemController implements the CRUD actions for NavItem model.
 */
class NavItemController extends Controller
{

    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'nav/item';
    }
    public function actions()
    {
        return [
            'position' => [
                'class' => 'backend\actions\Position',
                'returnUrl' => function($model){
                    return Url::to(['/nav/update', 'id' => $model->nav_id]);
                }
            ]
        ];
    }
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new NavItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nav_id)
    {
        $model = new NavItem();
        $nav = Nav::findOne($nav_id);
        if (!$nav) {
            throw new HttpException(400);
        }

        $model->nav_id =  $nav->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', '添加成功');
                return $this->redirect(['/nav/update', 'id' => $model->nav_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'nav' => $nav,
        ]);
    }

    /**
     * Updates an existing NavItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '更新成功');
            return $this->redirect(['/nav/update', 'id' => $model->nav_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing NavItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            return $this->redirect(['/nav/update', 'id'=>$model->nav_id]);
        };
    }

    /**
     * Finds the NavItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NavItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = NavItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
