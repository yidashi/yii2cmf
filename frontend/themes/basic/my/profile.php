<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form ActiveForm */
?>
<div class="profile">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'avatar')->widget(\yidashi\webuploader\Webuploader::className()) ?>
        <?= $form->field($model, 'money') ?>
        <?= $form->field($model, 'gender')->dropDownList($model->genderList) ?>
        <?= $form->field($model, 'signature')->textarea() ?>

    
        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile -->
