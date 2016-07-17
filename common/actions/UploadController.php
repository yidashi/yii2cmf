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

class UploadController extends Controller
{
    public function actions()
    {
        return [
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'type' => GetAction::TYPE_FILES,
            ],
            'image-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'modelClass' => 'common\models\Attachment',
                'callback' => function($result) {
                    return [
                        'filelink' => $result['files'][0]['url']
                    ];
                }
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'type' => GetAction::TYPE_IMAGES,
            ],
            'file-upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'uploadOnlyImage' => false,
                'modelClass' => 'common\models\Attachment',
                'callback' => function($result) {
                    return [
                        'filelink' => $result['files'][0]['url'],
                        'filename' => $result['files'][0]['filename']
                    ];
                }
            ],
            'upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'modelClass' => 'common\models\Attachment'
            ]
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