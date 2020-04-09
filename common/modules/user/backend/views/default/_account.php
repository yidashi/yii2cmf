<?php

use backend\widgets\ActiveForm;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

?>

<?php $this->beginContent(__DIR__ . '/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

<div class="form-group">
   <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
