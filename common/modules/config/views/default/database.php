<?php
use yii\widgets\ActiveForm;

use yii\helpers\Html;
/**
 * @var $this \yii\web\View
 */

$this->title = '数据库配置';
?>

<?php $form = ActiveForm::begin([
    'id' => 'db-setting-form',
]);
?>

	<?=$form->field($model, 'hostname')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control']) ?>

	<?=$form->field($model, 'username')->textInput(['autocomplete' => 'off','class' => 'form-control']) ?>

	<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>


	<?=$form->field($model, 'database')->textInput(['autocomplete' => 'off','class' => 'form-control']) ?>

    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block'])?>


<?php $form::end(); ?>