<?php
use yii\helpers\Html;
use backend\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>

<div class="box box-solid">
<?php if($model->isNewRecord):?>
    <div class="box-header with-border" >
        <h3 class="box-title"> 创建新规则</h3>
    </div>
    <?php $form->action = ['create'] ?>
<?php endif;?>

<div class="box-body">
<?= $form->field($model, 'pattern') ?>
<?= $form->field($model, 'route') ?>
<?= $form->field($model, 'defaults') ?>
<?= $form->field($model, 'suffix') ?>
<?= $form->field($model, 'verb') ?>
</div>
</div>
<div class="form-group">
    <?= Html::submitButton('提交', ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>