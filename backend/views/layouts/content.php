<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
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

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?php if (array_key_exists('demo', Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))): ?>
        <?php Yii::$app->session->setFlash('warning', '演示组权限有限,少很多功能,需要看全部功能请下载本源码') ?>
        <?php endif; ?>
        <?= \common\widgets\AlertPlus::widget()?>
        <?= $content ?>
    </section>
</div>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'alert-info',
    'header' => '<h3>提示</h3>',
    'footer' => \common\helpers\Html::button('确定', ['class' => 'btn btn-info', 'data-dismiss' => 'modal'])
])?>
<?php \yii\bootstrap\Modal::end()?>
<footer class="main-footer">
    <?= Yii::powered()?>
</footer>