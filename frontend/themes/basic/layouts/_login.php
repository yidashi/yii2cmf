<?php
use yii\helpers\Html;
?>
<div class="panel-body" id="login-modal" style="display: none;">
    <?php
    $loginFormModel = new \common\modules\user\models\LoginForm();
    $loginForm = \yii\widgets\ActiveForm::begin(['action' => ['/user/security/login']]);
    ?>
    <?= $loginForm
        ->field($loginFormModel, 'username')
        ->label(false)
        ->textInput(['placeholder' => $loginFormModel->getAttributeLabel('username')]) ?>

    <?= $loginForm
        ->field($loginFormModel, 'password')
        ->label(false)
        ->passwordInput(['placeholder' => $loginFormModel->getAttributeLabel('password')]) ?>

    <div class="form-group">
        <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'data-ajax' => '1', 'data-refresh-pjax-container' => 'header-container', 'data-callback' => '$.modal.close()']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end();$this->trigger('afterLogin'); ?>
</div>