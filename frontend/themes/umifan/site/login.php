<?php
/* @var $this \yii\web\view */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="container user-module">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 ">
            <div class="panel panel-default panel-page">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        登录					</h2>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username') ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div style="color:#999;margin:1em 0">
                        如果忘记了密码，你可以 <?= Html::a('重置密码', ['site/request-password-reset']) ?>.
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="ptl mb40">
                        <a href="<?= url(['/site/request-password-reset']) ?>">忘记密码?</a>
                        <span class="text-muted mhs">|</span>

                        <span class="text-muted">还没有注册帐号？</span>
                        <a href="<?= url(['site/signup']) ?>">立即注册</a>

                    <?php $this->trigger('afterLogin'); ?>
                </div>
            </div>

        </div>
    </div>
</div>