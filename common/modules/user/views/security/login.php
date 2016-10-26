<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\modules\user\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('common', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    如果忘记了密码，你可以 <?= Html::a('重置密码', ['/user/security/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?php
                    $loginOptions = [
                        'class' => 'btn btn-primary', 'name' => 'login-button'
                    ];
                    if (Yii::$app->request->isAjax) {
                        $loginOptions['data-ajax'] = 1;
                        $loginOptions['data-refresh-pjax-container'] = 'header-container';
                        $loginOptions['data-callback'] = '$.modal.close()';
                    }
                    ?>
                    <?= Html::submitButton('登录', $loginOptions) ?>

                    &nbsp;&nbsp;还没有帐号? <?= Html::a('马上注册', ['/user/registration/signup']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            <?php $this->trigger('afterLogin'); ?>
        </div>
    </div>
</div>
