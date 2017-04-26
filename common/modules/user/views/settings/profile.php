<?php

use common\modules\city\widgets\CityWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Profile */
/* @var $form ActiveForm */
$this->title = Yii::t('common', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container profile">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('../_menu')?>
        </div>
        <div class="col-md-9">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'qq')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'gender')->radioList($model->genderList) ?>
                <?= $form->field($model, 'locale')->dropDownList($model->localeList) ?>

                <?= $form->field($model, 'signature')->textarea() ?>

                <?= $form->field($model, 'area')->label('所在地')->widget(CityWidget::className(), [
                    'provinceAttribute' => 'province',
                    'cityAttribute' => 'city',
                    'areaAttribute' => 'area'
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!-- profile -->
