<?php
require(__DIR__ . '/../../vendor/autoload.php');

require __DIR__.'/../../Yii.php';

require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../../api/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../../api/config/main.php'),
    require(__DIR__ . '/../../api/config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();
