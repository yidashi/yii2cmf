<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

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
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-static-top',
        ],
    ]);
    $menuItems = [];
    $menuItems[] = ['label' => '首页', 'url' => Yii::$app->homeUrl];
    foreach (\common\models\Category::find()->where(['is_nav' => 1])->all() as $nav) {
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
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Html::img(Yii::$app->user->identity->profile->avatarUrl, ['width' => 32, 'height' => 32]),
            'linkOptions' => [
                'class' => 'avatar'
            ],
            'items' => [
                [
                    'label' => Html::icon('user') . ' 个人信息',
                    'url' => ['/my/profile'],
                ],
                [
                    'label' => Html::icon('book') . ' 我的投稿',
                    'url' => ['/my/article-list'],
                ],
                [
                    'label' => Html::icon('thumbs-up') . ' 我顶过的',
                    'url' => ['/my/up'],
                ],
                [
                    'label' => Html::icon('star') . ' 我收藏的',
                    'url' => ['/my/favourite'],
                ],
                [
                    'label' => Html::icon('sign-out') . ' 退出',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ]
            ]
        ];
    }
    $rightMenuItems[] = [
        'label'=>Yii::t('frontend', 'Language'),
        'items'=>array_map(function ($code) {
            return [
                'label' => Yii::$app->params['availableLocales'][$code],
                'url' => ['/site/set-locale', 'locale'=>$code],
                'active' => Yii::$app->language === $code
            ];
        }, array_keys(Yii::$app->params['availableLocales']))
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
        'encodeLabels' => false
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= \common\widgets\AlertPlus::widget()?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"><a href="<?= \yii\helpers\Url::to(['/page/index', 'name' => 'mianze'])?>">免责声明</a></div>
            <div class="col-sm-3"><a href="<?= \yii\helpers\Url::to(['/page/index', 'name' => 'aboutus'])?>">关于我们</a></div>
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
<!--回到顶部-->
<?= \common\widgets\scroll\Scroll::widget()?>
<?php if (YII_ENV_PROD):?>
<!--页脚-->
<?= Yii::$app->config->get('FOOTER')?>
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
