<?php

use common\modules\city\widgets\CityWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View 					$this
 * @var common\modules\user\models\User 		$user
 * @var common\modules\user\models\Profile 	$profile
 */

?>

<?php $this->beginContent('@common/modules/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($profile, 'qq')->textInput() ?>
<?= $form->field($profile, 'phone')->textInput() ?>
<?= $form->field($profile, 'gender')->radioList($profile->genderList) ?>
<?= $form->field($profile, 'locale')->dropDownList($profile->localeList) ?>

<?= $form->field($profile, 'signature')->textarea() ?>

<?= $form->field($profile, 'area')->label('所在地')->widget(CityWidget::className(), [
    'provinceAttribute' => 'province',
    'cityAttribute' => 'city',
    'areaAttribute' => 'area'
]) ?>


<div class="form-group">
   <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
