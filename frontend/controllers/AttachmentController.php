<?php
/**
 * Created by PhpStorm.
 * Author: ljt
 * DateTime: 2017/2/14 14:41
 * Description:
 */

namespace frontend\controllers;


use common\models\Attachment;
use yii\web\Controller;

class AttachmentController extends Controller
{
    public function actionDownload($id)
    {
        $model = Attachment::findOne($id);
        $filePath = \Yii::$app->storage->url2path($model->url);
        return \Yii::$app->response->sendFile($filePath);
    }
}