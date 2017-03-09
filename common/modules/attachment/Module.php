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
        $storage = [
            'class' => 'common\modules\attachment\components\Storage',
            'fs' => [
                'class' => 'creocoder\flysystem\LocalFilesystem',
                'path' => '@storagePath/upload',
            ],
            'baseUrl' => '@storageUrl/upload',
            'imageProcessor' => [
                'class' => 'common\modules\attachment\components\image\Local',
                'path' => '@storagePath/upload',
            ]
        ];
        if (isset($this->params['filesystem_type'])) {
            switch ($this->params['filesystem_type']) {
                case 'qiniu':
                    $storage['fs'] = [
                        'class' => 'common\\modules\\attachment\\components\\flysystem\\QiniuFilesystem',
                        'access' => $this->params['qiniu_access_key'],
                        'secret' => $this->params['qiniu_access_secret'],
                        'bucket' => $this->params['qiniu_bucket'],
                    ];
                    $storage['baseUrl'] = $this->params['qiniu_domain'];
                    $storage['imageProcessor'] = [
                        'class' => 'common\\modules\\attachment\\components\\image\\Qiniu'
                    ];
                    break;
            }
        }
        $app->set('storage', $storage);
    }
}