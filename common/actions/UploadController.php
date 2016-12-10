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
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class UploadController extends Controller
{
    public $enableCsrfValidation = false;
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
                    return !isset($result['files'][0]['error']) ? [
                        'filelink' => $result['files'][0]['url']
                    ] : [
                        'error' => $result['files'][0]['error']
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
                    return !isset($result['files'][0]['error']) ? [
                        'filelink' => $result['files'][0]['url'],
                        'filename' => $result['files'][0]['filename']
                    ] : [
                        'error' => $result['files'][0]['error']
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
            'images-upload' => [
                'class' => 'common\actions\UploadAction',
                'multiple' => true,
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment'
            ],
            'backend-files-upload' => [
                'class' => 'common\actions\UploadAction',
                'multiple' => true,
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment',
                'uploadOnlyImage' => false,
                'itemCallback' => function ($result) {
                    $result['updateUrl'] = Url::to(['/attachment/update', 'id' => $result['id']]);
                    return $result;
                }
            ],
            'md-image-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => Yii::$app->storage->baseUrl,
                'path' => Yii::$app->storage->basePath,
                'modelClass' => 'common\models\Attachment',
                'callback' => function($result) {
                    return !isset($result['files'][0]['error']) ? [
                        'success' => 1,
                        'url' => $result['files'][0]['url']
                    ] : [
                        'success' => 0,
                        'message' => $result['files'][0]['error']
                    ];
                }
            ],
        ];
    }

    public function actionDelete($id)
    {

    }
}