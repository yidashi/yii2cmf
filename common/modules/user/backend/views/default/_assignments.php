<?php

use rbac\widgets\Assignments;

/**
 * @var yii\web\View 				$this
 * @var common\modules\user\models\User 	$user
 */

?>

<?php $this->beginContent(__DIR__ . '/update.php', ['user' => $user]) ?>

<?= yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert-info',
    ],
    'body' => Yii::t('app', 'You can assign multiple roles or permissions to user by using the form below'),
]) ?>

<?= Assignments::widget(['userId' => $user->id]) ?>

<?php $this->endContent() ?>
