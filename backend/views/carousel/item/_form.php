<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CarouselItem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'image')->widget(\common\modules\attachment\widgets\SingleWidget::className(), ['onlyUrl' => true]) ?>

    </div>
    <div class="col-md-6">

        <?= $form->field($model, 'url')->textarea(['maxlength' => 1024]) ?>

        <?= $form->field($model, 'caption')->textarea() ?>

        <?= $form->field($model, 'sort')->textInput() ?>

        <?= $form->field($model, 'status')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
