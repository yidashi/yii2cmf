<?php
namespace backend\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class User extends \common\models\User
{
    public function attributes()
    {
    	return array_merge(parent::attributes(),['password']);
    }
    public function attributeLabels()
    {
    	return array_merge(parent::attributeLabels(),[
    		'password'=>'密码'
    	]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6]

        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['username', 'email'];
        $scenarios['resetPassword'] = ['password'];
        return $scenarios;
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new \common\models\User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function resetPassword()
    {
        $this->setPassword($this->password);
        unset($this->password);
        return $this->save(false);
    }
}
