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
    <?php $this->registerMetaTag(['name' => 'keywords', 'content' => \common\models\Config::get('SEO_SITE_KEYWORDS')]);?>
    <?php $this->registerMetaTag(['name' => 'description', 'content' => \common\models\Config::get('SEO_SITE_DESCRIPTION')]);?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header class="header" style="background:url(<?= \common\models\Config::get('PAGE_TOP_BG')?>) no-repeat;background-size: cover;">
        <h1><?= Html::a(Yii::$app->name, Yii::$app->homeUrl)?></h1>
    </header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    foreach(\common\models\Category::find()->all() as $nav){
        $menuItems[] = ['label' => $nav['title'], 'url' => ['/article/index','cate'=>$nav['name']]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    $rightMenuItems = [];
    $rightMenuItems[] = ['label' => '反馈', 'url' => ['/suggest/create']];
    $rightMenuItems[] = ['label' => '投稿', 'url' => ['/my/create-article']];
    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup'], 'options'=>['class'=>'pull-right']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                [
                    'label'=>'我的主页',
                    'url'=>['/my/settings']
                ],
                [
                    'label' => '我的投稿',
                    'url' => ['/my/article-list']
                ],
                [
                    'label' => '退出',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?php if(stripos(Yii::$app->request->headers->get('User-Agent'), 'MicroMessenger') === false): ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php endif; ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6"><a href="<?= \yii\helpers\Url::to(['/site/about'])?>">免责声明</a></div>
            <div class="col-sm-6"><a href="<?= \yii\helpers\Url::to(['/site/about'])?>">关于我们</a></div>
        </div>
    </div>
    <hr/>
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>
        <p class="pull-right"><?= Yii::$app->params['icp']?></p>
    </div>
</footer>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<a class="back-to-top btn btn-default" style="display: none;"><span class="fa fa-arrow-up"></span></a>
<?php if(YII_ENV_PROD): ?>
<script>
    (function(){
        var bp = document.createElement('script');
        bp.src = '//push.zhanzhang.baidu.com/push.js';
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
<!--百度统计-->
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?70a5fd220c5efb308f934681ea41aa0a";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
