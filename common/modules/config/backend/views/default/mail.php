<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 */

$this->title = '邮箱配置';
?>
<?php $form = ActiveForm::begin([
    'id' => 'mail-setting-form',
]); ?>

    <?=$form->field($model, 'mailHost')->textInput(['autocomplete' => 'off'])?>

    <?=$form->field($model, 'mailUsername')->textInput(['autocomplete' => 'off'])?>


    <?=$form->field($model, 'mailPassword')->passwordInput(['autocomplete' => 'off'])?>



    <?=$form->field($model, 'mailPort')->textInput(['autocomplete' => 'off'])?>


    <?=$form->field($model, 'mailEncryption')->dropDownList(['' => 'Default','ssl' => 'SSL','tls' => 'TLS'], ['class' => 'form-control'])?>


    <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn bg-maroon btn-flat btn-block'])?>


<?php $form::end(); ?>