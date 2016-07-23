<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午1:46
 */

namespace common\actions;


use common\models\Attachment;
use vova07\imperavi\actions\GetAction;
use yii\web\Controller;
use Yii;

class UploadController extends Controller
{
    public function actions()
    {
        return [
            'redactor-files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'type' => GetAction::TYPE_FILES,
            ],
            'redactor-image-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment',
                'callback' => function($result) {
                    return [
                        'filelink' => $result['files'][0]['url']
                    ];
                }
            ],
            'redactor-images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'type' => GetAction::TYPE_IMAGES,
            ],
            'redactor-file-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'uploadOnlyImage' => false,
                'modelClass' => 'common\models\Attachment',
                'callback' => function($result) {
                    return [
                        'filelink' => $result['files'][0]['url'],
                        'filename' => $result['files'][0]['filename']
                    ];
                }
            ],
            'image-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment'
            ],
            'file-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment',
                'uploadOnlyImage' => false
            ],
        ];
    }

    public function actionDelete($id)
    {
        $attachment = Attachment::findOne($id);
        if ($attachment) {
            if ($attachment->user_id == \Yii::$app->user->id){
                $attachment->delete();
            }
        }
    }
}