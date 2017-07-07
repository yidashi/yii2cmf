<?php


use kartik\select2\Select2;
use rbac\models\Assignment;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model Assignment
 */

?>

<?php if ($model->updated): ?>

<?= Alert::widget([
    'options' => [
        'class' => 'alert-success'
    ],
    'body' => Yii::t('app', 'Assignments have been updated'),
]) ?>

<?php endif ?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => false,
]) ?>

<?= Html::activeHiddenInput($model, 'user_id') ?>

<?= $form->field($model, 'items')->widget(Select2::className(), [
    'data' => $model->getAvailableRoles(),
    'options' => [
        'id' => 'items',
        'multiple' => true
    ],
]) ?>

<?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>

<?php ActiveForm::end() ?>

