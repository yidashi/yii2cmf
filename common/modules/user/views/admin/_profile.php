<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View 					$this
 * @var dektrium\user\models\User 		$user
 * @var dektrium\user\models\Profile 	$profile
 */

?>

<?php $this->beginContent('@common/modules/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false
]); ?>

<?= $form->field($profile, 'qq')->textInput() ?>
<?= $form->field($profile, 'phone')->textInput() ?>
<?= $form->field($profile, 'gender')->radioList($profile->genderList) ?>
<?= $form->field($profile, 'locale')->dropDownList($profile->localeList) ?>

<?= $form->field($profile, 'signature')->textarea() ?>

<?= $form->field($profile, 'area')->label('所在地')->widget(\common\widgets\city\CityWidget::className(), [
    'provinceAttribute' => 'province',
    'cityAttribute' => 'city',
    'areaAttribute' => 'area'
]) ?>


<div class="form-group">
   <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
