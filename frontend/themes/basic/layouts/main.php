<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\themes\basic\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => isset($this->params['seo_site_keywords']) ? $this->params['seo_site_keywords'] : Yii::$app->config->get('seo_site_keywords')
], 'keywords');
$this->registerMetaTag([
    'name' => 'description',
    'content' => isset($this->params['seo_site_description']) ? $this->params['seo_site_description'] : Yii::$app->config->get('seo_site_description')
], 'description');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="baidu-site-verification" content="MccTnGKbkm" />
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title ? Html::encode($this->title) . '-' . Yii::$app->config->get('site_name') : Yii::$app->config->get('site_name') ?></title>
    <link type="image/x-icon" href="<?= Yii::getAlias('@web') ?>favicon.ico" rel="shortcut icon">
    <script>var SITE_URL = '<?= Yii::$app->request->hostInfo . Yii::$app->request->baseUrl ?>';</script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (!(new \Detection\MobileDetect())->isMobile()): ?>
<?= $this->render('_header') ?>
<?php else: ?>
    <?= $this->render('_nav') ?>
<?php endif; ?>
<div class="container content-wrapper">
    <?php if (!(new \Detection\MobileDetect())->isMobile()): ?>
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?php endif; ?>
    <?= \common\widgets\Alert::widget()?>
    <?= $content ?>
</div>
<?= $this->render('_footer') ?>
<?php if(Yii::$app->user->isGuest): ?>
    <?= $this->render('_login') ?>
<?php endif; ?>
<!--回到顶部-->
<div class="fixed-btn">
    <a class="back-to-top"><span class="fa fa-arrow-up"></span></a>
    <a class="qrcode" data-original-title="" title=""><i class="fa fa-qrcode"></i></a>
</div>
<?php
$qrcode = \Yii::$app->config->get('wx.qrcode');
$app = \Yii::$app->config->get('app.download_qrcode');
$this->registerJs(<<<JS
// back-to-top
    $(window).scroll(function(){
        if ($(this).scrollTop() > 500) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    $(".back-to-top").click(function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
    $('.qrcode').popover({
        placement:'left',
        html:true,
        title:'关注公众号',
        content:'<img src="{$qrcode}" width="128" height="128">'
    });
JS
);
?>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>
