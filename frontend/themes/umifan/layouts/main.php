<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\themes\umifan\assets\AppAsset;

AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/themes/umifan/assets/images');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link type="image/x-icon" href="<?= Yii::getAlias('@web') ?>favicon.ico" rel="shortcut icon">
    <?php $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->config->get('SEO_SITE_KEYWORDS')]);?>
    <?php $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->config->get('SEO_SITE_DESCRIPTION')]);?>
    <script>var SITE_URL = '<?= Yii::$app->request->hostInfo . Yii::$app->request->baseUrl ?>';</script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-container" class="header-fixed-top">
    <!-- Main Container -->
    <div id="main-container">
        <?= $this->render('_nav') ?>
        <div id="page-content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
                    <?= $content ?>
        </div>
        <footer class="clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-xs-7">
                        Copyright © 2011-2018 <?= Yii::$app->config->get('FRONTEND_URL') ?>
                    </div>
                    <div class="col-xs-5">
                        <ul class="list-inline"><li class="active"><a href="/">首页</a></li>
                            <li><a href="/index.php?r=page%2Fread&amp;id=63">下载</a></li>
                            <li><a href="/index.php?r=page%2Fread&amp;id=64">特色</a></li>
                            <li><a href="<?= url(['/page/slug', 'slug' => 'aboutus']) ?>">关于我们</a></li></ul>                                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
