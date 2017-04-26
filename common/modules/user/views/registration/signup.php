<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\modules\user\models\SignupForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('common', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableAjaxValidation' => true]); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

                    &nbsp;&nbsp;已有帐号? <?= Html::a('马上登录', ['/user/security/login']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
