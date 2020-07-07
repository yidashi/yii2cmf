<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2020/7/4
 * Time: 11:04 上午
 */

namespace common\modules\education\backend\controllers;

use common\modules\attachment\components\UploadedFile;
use common\modules\education\models\Question;
use yii\web\Controller;

class QuestionController extends Controller
{
    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionTest2()
    {
        $content = \Yii::$app->request->post('content');
        //筛出所有图片
        $content = preg_replace_callback('/<img.*?src="(.*?)".*?\/>/', function ($matches) {
            $image = $matches[1];
            return '[[' . $this->uploadBase64Image($image) . ']]';
        }, $content);
        $content = strip_tags($content);
        Question::updateAll(['name' => $content]);
    }

    private function uploadBase64Image($base64Img)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Img, $result)) {
            $type = $result[2];
            if (in_array($type, array('pjpeg', 'jpeg', 'jpg', 'gif', 'bmp', 'png'))) {
                $stream = base64_decode(str_replace($result[1], '', $base64Img));
                $uploadFile = UploadedFile::getInstanceByStream($stream);
                $filename = $uploadFile->getHashName();
                $uploadFile->storeAs('', $filename);
                $imgUrl = \Yii::$app->storage->getUrl($filename);
                return $imgUrl;
            }
        }
    }
}
