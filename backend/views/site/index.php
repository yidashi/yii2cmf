<?php
use rbac\components\MenuHelper;
use rbac\models\Menu;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \yii\web\Controller */

backend\assets\AppAsset::register($this);
\backend\assets\IframeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->config->get('SITE_NAME') ?>管理后台</title>
    <?php $this->head() ?>
</head>
<body class="hold-transition <?= Yii::$app->config->get('BACKEND_SKIN', 'skin-green') ?> sidebar-mini fixed">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render('header.php') ?>

    <?= $this->render('content.php') ?>

</div>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>