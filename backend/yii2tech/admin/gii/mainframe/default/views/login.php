<?php
/**
 * This is the template for generating a login view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii2tech\admin\gii\mainframe\Generator */

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model <?= $generator->loginModelClass ?> */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = <?= $generator->generateString('Login') ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-5">
        <?= "<?php " ?> $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= "<?= " ?> $form->field($model, 'username') ?>

        <?= "<?= " ?> $form->field($model, 'password')->passwordInput() ?>

        <?= "<?php " ?> if (Yii::$app->user->enableAutoLogin) : ?>
            <?= "<?= " ?> $form->field($model, 'rememberMe')->checkbox() ?>
        <?= "<?php " ?> endif; ?>

        <div class="form-group">
            <?= "<?= " ?> Html::submitButton(<?= $generator->generateString('Login') ?>, ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?= "<?php " ?> ActiveForm::end(); ?>
    </div>
</div>
