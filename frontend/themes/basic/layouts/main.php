<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\Html;
use yii\helpers\Url;
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
    <link type="image/x-icon" href="<?= Yii::getAlias('@web') ?>favicon.ico" rel="shortcut icon">
    <?php $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->config->get('SEO_SITE_KEYWORDS')]);?>
    <?php $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->config->get('SEO_SITE_DESCRIPTION')]);?>
    <script>var SITE_URL = '<?= Yii::$app->request->hostInfo . Yii::$app->request->baseUrl ?>';</script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('_nav') ?>
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
        <div class="footer-link">
            <a href="<?= Url::to(['/page/index', 'name' => 'aboutus'])?>">关于我们</a>
            <a href="<?= Url::to(['/page/index', 'name' => 'mianze'])?>">免责声明</a>
            <a href="<?= Url::to(['/suggest'])?>" title="意见反馈">意见反馈</a>
        </div>
        <div class="friendly-link">
            <span>友情链接：</span>
            <?php foreach(Yii::$app->config->get('friendly_link') as $k => $v): ?>
            <a href="<?= $v ?>" target="_blank" title="<?= $k ?>"><?= $k ?></a>
            <?php endforeach; ?>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?= Yii::$app->config->get('SITE_NAME').' '.date('Y') ?></p>
            <p><?= Yii::$app->config->get('SITE_ICP')?></p>
        </div>
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
