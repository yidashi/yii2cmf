<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/4/13
 * Time: 5:11 下午
 */

namespace common\modules\education\frontend\controllers;

use common\modules\education\components\PaperDoc;
use common\modules\education\models\Paper;

class TestController extends \common\components\Controller
{
    public function actionDownload()
    {
        $paper_id = 1;
        $paper = Paper::findOne($paper_id);
        $paperDoc = new PaperDoc($paper);
        $docFile = $paperDoc->download();
        return \Yii::$app->response->sendFile($docFile, $paper->name . '.docx');
    }
}
