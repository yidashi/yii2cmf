<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nav */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="panel panel-primary">
    <div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'key')->textInput(['maxlength' => 1024]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 1024]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
