<?php

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/2/16
 * Time: 下午9:32
 */

namespace common\modules\attachment;

use common\modules\attachment\actions\UploadController;
use yii\base\BootstrapInterface;

class Module extends \common\modules\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $storage = [
            'class' => 'common\modules\attachment\components\FilesystemManager',
            'defaultDriver' => $this->params['default_driver'],
            'disks' => [
                'local' => [
                    'class' => 'common\\modules\\attachment\\components\\flysystem\\LocalFilesystem',
                    'path' => \Yii::getAlias($this->params['local_root']),
                    'url' => \Yii::getAlias($this->params['local_url']),
                ],
                'qiniu' => [
                    'class' => 'common\\modules\\attachment\\components\\flysystem\\QiniuFilesystem',
                    'access' => $this->params['qiniu_access_key'],
                    'secret' => $this->params['qiniu_access_secret'],
                    'bucket' => $this->params['qiniu_bucket'],
                    'domain' => $this->params['qiniu_domain']
                ]
            ]
        ];
        $app->set('storage', $storage);
        $app->controllerMap['upload'] = UploadController::className();
    }
}