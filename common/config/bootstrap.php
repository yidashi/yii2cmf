<?php
Yii::setAlias('root', dirname(dirname(__DIR__)));
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('database', dirname(dirname(__DIR__)) . '/database');
Yii::setAlias('plugins', dirname(dirname(__DIR__)) . '/plugins');
Yii::setAlias('yii2tech', '@backend/yii2tech');





Yii::setAlias('storagePath', '@root/web/storage');
Yii::setAlias('storageUrl', env('STORAGE_URL', env('FRONTEND_URL/storage')));

Yii::$container->set('yidashi\markdown\Markdown', ['useUploadImage' => true]);
Yii::$container->set('yii\widgets\LinkPager', ['firstPageLabel' => '首页', 'lastPageLabel' => '末页']);
Yii::$container->set('common\widgets\EditorWidget', ['type' => env('EDITOR_TYPE', 'redactor')]);