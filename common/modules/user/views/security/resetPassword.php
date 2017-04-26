<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\modules\user\models\User */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <p>请设置新密码:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
