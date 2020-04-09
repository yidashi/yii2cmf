<?php

use backend\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="panel panel-primary">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'key')->textInput(['maxlength' => 1024]) ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'status')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => 'btn btn-primary btn-flat']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
