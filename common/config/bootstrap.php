<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('runnerScript', dirname(dirname(dirname(__FILE__))) .'/yii');
Yii::setAlias('staticroot', dirname(dirname(__DIR__)) . '/static');
if (YII_ENV_PROD) {
    Yii::setAlias('static', 'http://image.51siyuan.cn');
} else {
    Yii::setAlias('static', 'http://127.0.0.1/yii/static');
}