<?php

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/2/16
 * Time: 下午9:32
 */

namespace common\modules\attachment;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->set('storage', [
            'class' => 'common\\modules\\attachment\\components\\Storage',
            'fs' => [
//                'class' => 'creocoder\flysystem\LocalFilesystem',
//                'path' => '@storagePath/upload',
                'class' => 'common\\modules\\attachment\\components\\flysystem\\QiniuFilesystem',
                'access' => 'EMBSLKU4SR4O8bHVteOY4F4Od2fYaty4aYY3PsR9',
                'secret' => 'L2DdJkn3A8scKa3wbaktz6vU-tj8H9oLnZhU7yCn',
                'bucket' => 'siyuan',
            ],
            'baseUrl' => 'http://image.51siyuan.cn',
            'imageProcessor' => [
                'class' => 'common\\modules\\attachment\\components\\image\\Qiniu',
            ]
        ]);
    }
}