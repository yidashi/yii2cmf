<?php
require __DIR__.'/../../vendor/autoload.php';

// Environment
(new \Dotenv\Dotenv(dirname(dirname(__DIR__))))->load();

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'prod'));

require __DIR__.'/../../vendor/yiisoft/yii2/Yii.php';

// Config
require __DIR__.'/../../common/config/bootstrap.php';
require __DIR__.'/../../backend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__.'/../../common/config/main.php'),
    require(__DIR__.'/../../common/config/main-local.php'),
    require(__DIR__.'/../../backend/config/main.php'),
    require(__DIR__.'/../../backend/config/main-local.php')
);

(new yii\web\Application($config))->run();
