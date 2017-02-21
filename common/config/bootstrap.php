<?php
Yii::$classMap['yii\helpers\Html'] = '@common/helpers/Html.php';
Yii::$classMap['yii\helpers\Markdown'] = '@common/helpers/Markdown.php';

Yii::setAlias('root', dirname(dirname(__DIR__)));
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('wechat', dirname(dirname(__DIR__)) . '/wechat');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('database', dirname(dirname(__DIR__)) . '/database');
Yii::setAlias('plugins', dirname(dirname(__DIR__)) . '/plugins');



Yii::setAlias('storagePath', '@root/web/storage');
Yii::setAlias('storageUrl', env('SITE_URL') . '/storage');


Yii::$container->set('yii\widgets\LinkPager', ['maxButtonCount' => 5, 'firstPageLabel' => '首页', 'lastPageLabel' => '末页']);
Yii::$container->set('yii\widgets\Pjax', ['timeout' => false]);
