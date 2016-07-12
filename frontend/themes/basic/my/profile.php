<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form ActiveForm */
$this->title = Yii::t('common', 'Profile');
?>
<div class="profile">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'avatar')->widget(\yidashi\webuploader\Cropper::className(), [
            'options' => [
                'previewWidth' => 200,
                'previewHeight' => 200
            ]
        ]) ?>
        <?= $form->field($model, 'gender')->radioList($model->genderList) ?>
        <?= $form->field($model, 'locale')->dropDownList($model->localeList) ?>
        <?= $form->field($model, 'signature')->textarea() ?>

        <?= $form->field($model, 'area')->label('所在地')->widget(\common\widgets\area\Area::className(), [
            'provinceAttribute' => 'province',
            'cityAttribute' => 'city',
            'areaAttribute' => 'area'
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile -->
