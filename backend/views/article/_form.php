<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($dataModel, 'content')->widget('kucha\ueditor\UEditor', ['options' => ['style' => 'height:500px']]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(\common\models\Category::find()->select('title')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'cover')->widget('yidashi\webuploader\Webuploader') ?>

    <?= $form->field($model, 'status')->dropDownList([0 => '待审核', 1 => '正常']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
