<?php
use rbac\components\MenuHelper;
use rbac\models\Menu;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \yii\web\Controller */

backend\assets\AppAsset::register($this);
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
<body class="hold-transition <?= Yii::$app->config->get('BACKEND_SKIN', 'skin-green') ?> ">
<?php $this->beginBody() ?>
<style>
    .content-wrapper, .right-side, .main-footer {margin-left:0!important;}
    .btn-refresh {
        position: fixed;
        bottom: 100px;
        right: 2px;
        padding: 3px 8px;
        font-size: 24px;
        border:1px solid #ccc;
        border-radius:4px;
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <section class="content">
        <?= \common\widgets\Alert::widget()?>
        <?= $content ?>
    </section>
</div>
<?= Html::a(Html::icon('refresh'), 'javascript:;', ['class' => 'btn btn-success btn-refresh', 'onclick' => 'location.reload()']) ?>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])): ?>
    <?= $this->blocks['js'] ?>
<?php endif; ?>
</body>
</html>
<?php $this->endPage() ?>