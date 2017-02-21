<?php
$form = \yii\widgets\ActiveForm::begin([
    'id' => 'default-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'SITE_URL')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>

<?php \yii\widgets\ActiveForm::end(); ?>