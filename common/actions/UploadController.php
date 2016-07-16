<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午1:46
 */

namespace common\actions;


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
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'type' => GetAction::TYPE_IMAGES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
                'uploadOnlyImage' => false
            ],
            'upload' => [
                'class' => 'common\actions\UploadAction',
                'url' => \Yii::getAlias('@static/upload'),
                'path' => '@staticroot/upload',
            ]
        ];
    }
}