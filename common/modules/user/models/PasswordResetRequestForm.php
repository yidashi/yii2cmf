<?php

namespace common\modules\user\models;

use yii\base\Model;

/**
 * Password reset request form.
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.',
            ],
        ];
    }
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
        ];
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findByEmail($this->email);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                $mailer = \Yii::$app->mailer;
                $mailer->viewPath = '@common/modules/user/mail';
                return $mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                    ->setFrom([\Yii::$app->config->get('ADMIN_EMAIL') => \Yii::$app->config->get('SITE_NAME').' robot'])
                    ->setTo($this->email)
                    ->setSubject('重置密码 -' . \Yii::$app->config->get('SITE_NAME'))
                    ->send();
            }
        }

        return false;
    }
}
