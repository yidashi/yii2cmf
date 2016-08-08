<?php

/* @var $this yii\web\View */
/* @var $user common\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/security/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
