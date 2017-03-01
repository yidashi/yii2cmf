<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午1:46
 */

namespace common\modules\attachment\controllers;


use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\modules\attachment\actions\UploadAction;
use common\modules\attachment\actions\GetAction;

class UploadController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'redactor-files-get' => [
                'class' => GetAction::className(),
                'type' => 'files',
            ],
            'redactor-image-upload' => [
                'class' => UploadAction::className(),
                'callback' => function($result) {
                    return !isset($result['files'][0]['error']) ? [
                        'filelink' => $result['files'][0]['url']
                    ] : [
                        'error' => $result['files'][0]['error']
                    ];
                }
            ],
            'redactor-images-get' => [
                'class' => GetAction::className(),
                'type' => 'images',
            ],
            'redactor-file-upload' => [
                'class' => UploadAction::className(),
                'uploadOnlyImage' => false,
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
                'class' => UploadAction::className(),
            ],
            'avatar-upload' => [
                'class' => UploadAction::className(),
                'path' => 'avatar',
                'validatorOptions' => ['minWidth' => 100, 'minHeight' => 100, 'underWidth' => '图片宽高不要小于100x100', 'underHeight' => '图片宽高不要小于100x100']
            ],
            'file-upload' => [
                'class' => UploadAction::className(),
                'uploadOnlyImage' => false
            ],
            'images-upload' => [
                'class' => UploadAction::className(),
                'multiple' => true,
            ],
            'backend-files-upload' => [
                'class' => UploadAction::className(),
                'multiple' => true,
                'uploadOnlyImage' => false,
                'itemCallback' => function ($result) {
                    $result['updateUrl'] = Url::to(['/attachment/update', 'id' => $result['id']]);
                    return $result;
                }
            ],
            'md-image-upload' => [
                'class' => UploadAction::className(),
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
            'im-image-upload' => [
                'class' => UploadAction::className(),
                'callback' => function($result) {
                    return !isset($result['files'][0]['error']) ? [
                        'code' => 0,
                        'msg' => '',
                        'data' => [
                            'src' => $result['files'][0]['url']
                        ]
                    ] : [
                        'code' => 0,
                        'msg' => $result['files'][0]['error'],
                        'data' => (object)[]
                    ];
                }
            ],
            'im-file-upload' => [
                'class' => UploadAction::className(),
                'uploadOnlyImage' => false,
                'callback' => function($result) {
                    return !isset($result['files'][0]['error']) ? [
                        'code' => 0,
                        'msg' => '',
                        'data' => [
                            'src' => $result['files'][0]['url'],
                            'name' => $result['files'][0]['filename']
                        ]
                    ] : [
                        'code' => 0,
                        'msg' => $result['files'][0]['error'],
                        'data' => (object)[]
                    ];
                }
            ],
        ];
    }

    public function actionDelete($id)
    {
        //TODO AttachmentIndex里没有该attachment_id就可以把attachment删了
    }
}