<?php
namespace common\modules\config\models;

use yii\base\Model;

class MailConfigForm extends Model
{
    use ConfigTrait;

    public $mailHost;

    public $mailUsername;

    public $mailPassword;

    public $mailPort;

    public $mailEncryption;

    public function rules()
    {
        return [
            // Host
            ['mailHost', 'required'],
            ['mailHost', 'string', 'max' => 255],
            // Username
            ['mailUsername', 'required'],
            ['mailUsername', 'string', 'max' => 255],

            // Password
            ['mailPassword', 'required'],
            ['mailPassword', 'string', 'max' => 255],

            // Port
            ['mailPort', 'required'],
            ['mailPort', 'integer'],

            // Encryption
            ['mailEncryption', 'string', 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mailHost' => 'Host',
            'mailUsername' => 'Username',
            'mailPassword' => 'Password',
            'mailPort' => 'Port',
            'mailEncryption' => 'Encryption',
        ];
    }

    public function loadDefaultValues()
    {
        $config = $this->getConfig();
        $this->mailHost = $config->get('MAIL_HOST');
        $this->mailUsername = $config->get('MAIL_USERNAME');
        $this->mailPassword = $config->get('MAIL_PASSWORD');
        $this->mailPort = $config->get('MAIL_PORT');
        $this->mailEncryption = $config->get('MAIL_ENCRYPTION');
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }
        $config = $this->getConfig();
        $config->set('MAIL_HOST', $this->mailHost);
        $config->set('MAIL_USERNAME', $this->mailUsername);
        $config->set('MAIL_PASSWORD', $this->mailPassword);
        $config->set('MAIL_PORT', $this->mailPort);
        $config->set('MAIL_ENCRYPTION', $this->mailEncryption);

        return true;
    }
}