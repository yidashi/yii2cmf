<?php

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'database-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>

<h2>Input mysqli info</h2>
<?=$form->field($model, 'hostname')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'port')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'username')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
<?=$form->field($model, 'database')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'prefix')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>

<?php \yii\widgets\ActiveForm::end(); ?>