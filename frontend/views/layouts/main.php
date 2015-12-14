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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/']],
    ];
    foreach(\common\models\Category::find()->all() as $nav){
        $menuItems[] = ['label' => $nav['title'], 'url' => ['/article/index','cid'=>$nav['id']]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    $rightMenuItems = [];
//    $rightMenuItems[] = ['label' => '下载', 'url' => ['/download']];
    $rightMenuItems[] = ['label' => '投稿', 'url' => ['/article/create']];
    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup'], 'options'=>['class'=>'pull-right']];
        $rightMenuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => ['/user/index'],
            'items' => [
                [
                    'label'=>'设置',
                    'url'=>['/usr/settings']
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
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>

<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
    </div>
</footer>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<a class="back-to-top btn btn-default" style="display: none;"><span class="fa fa-arrow-up"></span></a>
<?php if(YII_ENV_PROD): ?>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=53223522" charset="UTF-8"></script>
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
