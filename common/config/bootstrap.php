<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('database', dirname(dirname(__DIR__)) . '/database');
Yii::setAlias('plugins', dirname(dirname(__DIR__)) . '/plugins');





Yii::setAlias('runnerScript', dirname(dirname(dirname(__FILE__))) .'/yii');
Yii::setAlias('staticroot', dirname(dirname(__DIR__)) . '/web/static');
Yii::setAlias('static', env('STATIC_URL'));

Yii::$container->set('yidashi\markdown\Markdown', ['useUploadImage' => true]);
Yii::$container->set('yii\widgets\LinkPager', ['firstPageLabel' => '首页', 'lastPageLabel' => '末页']);