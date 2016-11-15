<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/19
 * Time: 上午12:05
 */

namespace frontend\themes\basic;

use Yii;

class Theme extends \frontend\themes\Theme
{
    public $info = [
        'author' => '易大师',
        'id' => 'basic',
        'name' => '基本',
        'version' => 'v1.0',
        'description' => '基础主题',
        'keywords' => '基础 经典'
    ];

    public function bootstrap()
    {
        Yii::$container->set('yii\bootstrap\BootstrapAsset', [
            'sourcePath' => '@frontend/themes/basic/static',
            'css' => [
                YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
            ]
        ]);
    }
}