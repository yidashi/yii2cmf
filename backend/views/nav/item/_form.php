<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NavItem */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="panel panel-primary">
    <div class="panel-body">
        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'url')->textarea(['maxlength' => 1024]) ?>

        <?= $form->field($model, 'target')->checkbox() ?>

        <?= $form->field($model, 'status')->checkbox() ?>
    </div>
    <div class="panel-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
