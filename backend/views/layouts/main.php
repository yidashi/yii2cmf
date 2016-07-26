<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

backend\assets\AppAsset::register($this);
\common\assets\PaceAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition <?= Yii::$app->config->get('BACKEND_SKIN', 'skin-green') ?> sidebar-mini fixed">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header.php'
    ) ?>

    <?= $this->render(
        'left.php')
    ?>

    <?= $this->render(
        'content.php',
        ['content' => $content]
    ) ?>

</div>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>