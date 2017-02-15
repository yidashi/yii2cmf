<?php
$form = \yii\widgets\ActiveForm::begin([
    'id' => 'default-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'appName')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>

<?php \yii\widgets\ActiveForm::end(); ?>