<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->widget(\common\widgets\EditorWidget::className()) ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'use_layout')->checkbox() ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => 'btn btn-flat bg-maroon btn-block']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    </div>
</div>
