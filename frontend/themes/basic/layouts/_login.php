<?php
/**
 * @var yii\web\View $this
 */
use yii\helpers\Html;
?>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'modal-login',
    'header' => '<span style="color: #e26005;font-size: 18px;">登录</span>',
    'size' => 'modal-sm'
]) ?>
    <?php
    $loginFormModel = new \common\modules\user\models\LoginForm();
    $loginForm = \yii\widgets\ActiveForm::begin([
        'action' => ['/user/security/login'],
        'id' => 'form-login',
        'options' => ['data-ajax' => '1', 'data-refresh-pjax-container' => 'header-container', 'data-callback' => '$("#modal-login").modal("hide")']
    ]);
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
        <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <?= \common\modules\user\widgets\AuthChoice::widget([
        'id' => 'auth-login',
        'baseAuthUrl' => ['/user/security/auth'],
        'popupMode' => true,
    ]); ?>
<?php \yii\bootstrap\Modal::end() ?>
