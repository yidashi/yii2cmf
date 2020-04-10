<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'cron')->textInput(['placeholder' => '分 时 天 月 周']) ?>
        <?= $form->field($model, 'job') ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => 'btn btn-primary btn-flat btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
