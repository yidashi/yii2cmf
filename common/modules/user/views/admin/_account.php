<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

?>

<?php $this->beginContent("@common/modules/user/views/admin/update.php", ['user' => $user]) ?>

<?php $form = ActiveForm::begin(); ?>

<?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

<div class="form-group">
   <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
