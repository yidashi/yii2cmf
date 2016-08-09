<?php

/* @var $this yii\web\View */
/* @var $user common\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/security/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('user', 'Hello') ?>,

<?= Yii::t('user', 'We have received a request to reset the password for your account on {0}', Yii::$app->config->get('SITE_NAME')) ?>.
<?= Yii::t('user', 'Please click the link below to complete your password reset') ?>.

<?= $resetLink ?>

<?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.

<?= Yii::t('user', 'If you did not make this request you can ignore this email') ?>.
