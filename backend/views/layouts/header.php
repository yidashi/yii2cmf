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
