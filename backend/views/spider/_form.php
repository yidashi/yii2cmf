<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Spider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_dom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'list_dom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_dom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_dom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_dom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'target_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'target_category_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat btn-block' : 'btn btn-primary btn-flat block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
