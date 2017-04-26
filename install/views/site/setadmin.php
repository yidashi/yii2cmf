<?php

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'admin-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'username')->textInput(['class' => 'form-control'])?>
<?=$form->field($model, 'email')->textInput(['class' => 'form-control'])?>
<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
<?=$form->field($model, 'passwordConfirm')->passwordInput(['class' => 'form-control'])?>

<?php \yii\widgets\ActiveForm::end(); ?>