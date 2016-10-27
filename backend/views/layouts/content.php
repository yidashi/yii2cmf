<?php
use yii\widgets\Breadcrumbs;

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
        <?php Yii::$app->session->setFlash('warning', '演示组权限有限,只能看不能提交修改,需要全部功能请<a href="http://www.51siyuan.cn/code.html" target="_blank">下载源码</a>') ?>
        <?php endif; ?>
        <?= \common\widgets\Alert::widget()?>
        <?= $content ?>
    </section>
</div>
<footer class="main-footer">
    <?= Yii::powered()?>
</footer>