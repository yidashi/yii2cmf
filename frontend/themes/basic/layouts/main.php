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
            <?php if(Yii::$app->config->get('FRIENDLY_LINK')): ?>
            <?php foreach(Yii::$app->config->get('FRIENDLY_LINK') as $k => $v): ?>
            <a href="<?= $v ?>" target="_blank" title="<?= $k ?>"><?= $k ?></a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?= Yii::$app->config->get('SITE_NAME').' '.date('Y') ?></p>
            <p><?= Yii::$app->config->get('SITE_ICP')?></p>
        </div>
    </div>
</footer>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'alert-info',
    'header' => '<h3>提示</h3>',
    'footer' => \common\helpers\Html::button('确定', ['class' => 'btn btn-info', 'data-dismiss' => 'modal'])
])?>
<?php \yii\bootstrap\Modal::end()?>
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
