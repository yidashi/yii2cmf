<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var yii\web\View $this
 * @var rbac\models\AuthItem $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'className')->textInput() ?>

    <div class="form-group">
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('rbac', 'Create') : Yii::t('rbac', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat', ])
        ?>
    </div>

<?php ActiveForm::end(); ?>
</div>
