<?php

/**
 * @var yii\widgets\ActiveForm 		$form
 * @var common\modules\user\models\User 	$user
 */
?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
