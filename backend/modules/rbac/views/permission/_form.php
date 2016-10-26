<?php

use rbac\AutocompleteAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model rbac\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule-name']) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('rbac', 'Create') : Yii::t('rbac', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat', ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
AutocompleteAsset::register($this);

$options = Json::htmlEncode([
    'source' => array_keys(Yii::$app->authManager->getRules()),
]);
$this->registerJs("$('#rule-name').autocomplete($options);");
