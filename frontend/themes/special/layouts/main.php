<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->config->get('SEO_SITE_KEYWORDS')]);?>
    <?php $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->config->get('SEO_SITE_DESCRIPTION')]);?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header class="header" style="background:url(<?= Yii::$app->config->get('PAGE_TOP_BG')?>) no-repeat;background-size: cover;">
        <div class="container">
            <div class="header-content">
                <h1 class="pull-left"><?= Html::a(Yii::$app->config->get('SITE_NAME'), Yii::$app->homeUrl)?></h1>
                <form role="search" class="form-inline pull-right">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="搜索" id="bdcsMain">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </header>
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
    ]);
    $menuItems = [];
    $menuItems[] = ['label' => '首页', 'url' => Yii::$app->homeUrl];
    foreach (\common\models\Category::find()->all() as $nav) {
        $menuItems[] = ['label' => $nav['title'], 'url' => ['/article/index', 'cate' => $nav['name']]];
    }
    foreach (\common\models\Nav::find()->all() as $nav) {
        $menuItems[] = ['label' => $nav['title'], 'url' => $nav['route']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    $rightMenuItems = [];
    $rightMenuItems[] = ['label' => '投稿', 'url' => ['/my/create-article']];
    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup'], 'options' => ['class' => 'pull-right']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                [
                    'label' => '我的投稿',
                    'url' => ['/my/article-list'],
                ],
                [
                    'label' => '退出',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ],
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"><a href="<?= \yii\helpers\Url::to(['/page?id=1'])?>">免责声明</a></div>
            <div class="col-sm-3"><a href="<?= \yii\helpers\Url::to(['/page?id=2'])?>">关于我们</a></div>
            <div class="col-sm-3"><a href="<?= \yii\helpers\Url::to(['/suggest/create'])?>">问题反馈</a></div>
            <div class="col-sm-3"><a href="https://github.com/yidashi/yii">获取源码</a></div>
        </div>
    </div>
    <hr/>
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->config->get('SITE_NAME').' '.date('Y') ?></p>
        <p class="pull-right"><?= Yii::$app->config->get('SITE_ICP')?></p>
    </div>
</footer>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<a class="back-to-top btn btn-default" style="display: none;"><span class="fa fa-arrow-up"></span></a>
<?php if (YII_ENV_PROD):?>
<!--页脚-->
<?= Yii::$app->config->get('FOOTER')?>
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
