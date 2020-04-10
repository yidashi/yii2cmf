<?php

use backend\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="panel panel-primary">
    <div class="panel-body">

        <?= $form->field($model, 'key')->textInput(['maxlength' => 1024]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->checkbox() ?>
    </div>
    <div class="panel-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
