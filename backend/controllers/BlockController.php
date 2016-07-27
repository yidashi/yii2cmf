<?php
namespace backend\controllers;

use common\models\Block;
use frontend\widgets\area\TextWidget;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class BlockController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii2tech\admin\actions\Index',
                'modelClass' => 'common\models\Block'
            ],
            'delete' => [
                'class' => 'yii2tech\admin\actions\Delete',
            ]
        ];
    }


    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type=null)
    {
        if($type == null)
        {
            $type = 'text';
        }

//        list($title,$model,$view,$widget) = AreaHelp::getBlockHook($type);

//        $model = \Yii::createObject($model);
        $model = new Block();
        $model->loadDefaultValues();
        $model->type = $type;
        $model->widget = TextWidget::className();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('common', 'created success'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('common', 'created error. {0}', $model->formatErrors()));
            }
            return  $this->refresh();
        }

        return $this->render('create',["model"=>$model]);
    }




    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('common', 'updated success'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('common', 'updated error. {0}', $model->formatErrors()));
            }
            return  $this->refresh();
        }


        return $this->render('update',['model' => $model]);

    }


    public function findModel($id)
    {
        if (($model = Block::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
}

