<?php

namespace backend\controllers;

use common\models\Carousel;
use common\models\CarouselItem;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * CarouselItemController implements the CRUD actions for CarouselItem model.
 */
class CarouselItemController extends Controller
{

    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'carousel/item';
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
    public function actions()
    {
        return [
            'position' => [
                'class' => 'backend\actions\Position',
                'returnUrl' => function($model){
                    return Url::to(['/carousel/update', 'id' => $model->carousel_id]);
                }
            ],
            'switcher' => [
                'class' => 'backend\widgets\grid\SwitcherAction'
            ]
        ];
    }
    /**
     * Creates a new CarouselItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $carousel_id
     * @return mixed
     * @throws HttpException
     */
    public function actionCreate($carousel_id)
    {
        $model = new CarouselItem();
        $carousel = Carousel::findOne($carousel_id);
        if (!$carousel) {
            throw new HttpException(400);
        }

        $model->carousel_id =  $carousel->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('common', 'created success'));
                return $this->redirect(['/carousel/update', 'id' => $model->carousel_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'carousel' => $carousel,
        ]);
    }

    /**
     * Updates an existing CarouselItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('backend', 'Carousel slide was successfully saved'));
            return $this->redirect(['/carousel/update', 'id' => $model->carousel_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarouselItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            return $this->redirect(['/carousel/update', 'id'=>$model->carousel_id]);
        };
    }

    /**
     * Finds the CarouselItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarouselItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = CarouselItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
