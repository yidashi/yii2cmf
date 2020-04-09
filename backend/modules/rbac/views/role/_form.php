<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model rbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="box box-primary">
    <div class="box-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

        <?= $form->field($model, 'ruleName')->dropDownList(\backend\modules\rbac\components\RuleHelper::enums(), ['prompt' => '请选择']) ?>

        <?= $form->field($model, 'data')->textarea() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

