<?php
use backend\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(); ?>

<div class="box box-solid">
<div class="box-body">
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'slug') ?>
<?= $form->field($model, 'description')->textarea() ?>
</div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>