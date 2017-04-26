<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/10
 * Time: 下午7:03
 */

namespace common\modules\attachment\controllers;

use Yii;
use common\modules\attachment\models\Attachment;
use yii\imagine\Image;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;


class AdminController extends Controller
{
    /**
     * Lists all Gather models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attachment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                $error = current($model->getFirstErrors());
                return $this->renderJson(0, $error);
            }
        }

        $content = $this->renderPartial('view', [
            'model' => $model
        ]);

        return $this->renderJson(1, $content);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUploader()
    {
        return $this->render("uploader");
    }

    public function actionCrop($id)
    {
        $model = $this->findModel($id);
        $type = \Yii::$app->getRequest()->post("type");
        $x = \Yii::$app->getRequest()->post("x");
        $y = \Yii::$app->getRequest()->post("y");
        $w = \Yii::$app->getRequest()->post("w");
        $h = \Yii::$app->getRequest()->post("h");
        $newModel = $model->makeCropStorage($w, $h, $x, $y);
        //删除原图
        $model->delete();
        $newModel->updateAttributes(['id' => $model->id]);
        return $this->renderJson(1, "裁剪成功");
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->isAjax) {
            return $this->renderJson(1, '删除成功');
        }
        return $this->redirect(['index']);
    }
    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}