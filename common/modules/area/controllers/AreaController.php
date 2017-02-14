<?php
namespace common\modules\area\controllers;

use common\enums\BooleanEnum;
use common\modules\area\models\Area;
use common\modules\area\models\Block;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
{

    public function actionIndex()
    {
        return $this->render("index", [
            "blocks" => Block::find()->all(),
            "areas" => Area::find()->all()
        ]);
    }

    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Area();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
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
     * Deletes an existing Area model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionUpdateBlocks()
    {
        Yii::$app->response->format = 'json';
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        if($model->save()) {
            return [
                'status' => true,
                'msg' => '更新成功'
            ];
        } else {
            return [
                'status' => false,
                'msg' => '更新失败'
            ];
        }
    }

    public function actionUpdateBlocksDelete()
    {
        Yii::$app->response->format = 'json';
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");

        $block = \Yii::$app->getRequest()->post("block");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        $block = Block::findOne($block);

        $block->used = BooleanEnum::FLASE;

        if($model->save() && $block->save()) {
            return [
                'status' => true,
                'msg' => '更新成功'
            ];
        } else {
            return [
                'status' => false,
                'msg' => '更新失败'
            ];
        }
    }

    public function actionUpdateBlocksCreate()
    {
        Yii::$app->response->format = 'json';
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");

        $block = \Yii::$app->getRequest()->post("block");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        $block = Block::findOne($block);

        $block->used = BooleanEnum::TRUE;

         if($model->save() && $block->save()) {
             return [
                 'status' => true,
                 'msg' => '更新成功'
             ];
         } else {
             return [
                 'status' => false,
                 'msg' => '更新失败'
             ];
         }
    }

    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
