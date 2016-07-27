<?php
namespace backend\controllers;

use common\enums\BooleanEnum;
use common\models\Area;
use common\models\Block;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
{

    public function actions()
    {
        return [
            'create' => [
                'class' => 'yii2tech\admin\actions\Create',
            ],
            'update' => [
                'class' => 'yii2tech\admin\actions\Update',
            ],
            'delete' => [
                'class' => 'yii2tech\admin\actions\Delete',
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render("index", [
            "blocks" => Block::find()->where(["used" => BooleanEnum::FLASE])->all(),
            "areas" => Area::find()->all()
        ]);
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

    public function newModel()
    {
        return new Area();
    }
}
