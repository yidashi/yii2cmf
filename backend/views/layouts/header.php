<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li id="log-dropdown" class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?php echo sprintf('你有%d条日志', \backend\models\SystemLog::find()->count()) ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                    <li>
                                        <a href="<?php echo Yii::$app->urlManager->createUrl(['/log/view', 'id'=>$logEntry->id]) ?>">
                                            <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                            <?php echo $logEntry->category ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="footer">
                            <?php echo Html::a('查看全部', ['/log/index']) ?>
                        </li>
                    </ul>
                </li>
                <li><a href="<?= \yii\helpers\Url::to(['/site/demo', 'view' => 'icons'])?>">icons list</a></li>
                <li class="dropdown system-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= \yii\helpers\Url::to(['/user/reset-password', 'id' => \Yii::$app->user->id]) ?>">修改密码</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" data-method="post">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
