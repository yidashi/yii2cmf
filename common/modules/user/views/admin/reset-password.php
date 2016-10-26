<?php
/**
 * Author: yidashi
 * Date: 2015/11/3
 * Time: 14:54
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '重置密码';
 ?>
<div >
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('确定', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
