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
                'targetClass' => '\common\modules\user\models\User',
                'filter' => ['blocked_at' => null],
                'message' => '邮箱不存在',
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
                    ->setFrom([\Yii::$app->config->get('MAIL_USERNAME') => \Yii::$app->config->get('SITE_NAME').' robot'])
                    ->setTo($this->email)
                    ->setSubject('重置密码 -' . \Yii::$app->config->get('SITE_NAME'))
                    ->send();
            }
        }

        return false;
    }
}
