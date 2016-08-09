<?php

namespace common\modules\user\models;

use common\models\Sign;
use common\modules\user\traits\ModuleTrait;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return array_merge($scenarios, [
            'register' => ['username', 'email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password'],
            'update'   => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password'],
            'resetPassword' => ['password']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required', 'on' => 'create'],
            ['email', 'required', 'on' => 'create'],
            ['password', 'required', 'on' => ['register']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'status' => '状态',
            'created_at' => '注册时间',
            'login_at' => '最后登录时间'
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => '正常',
            self::STATUS_DELETED => '禁用'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'blocked_at' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username or email.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])
            ->andWhere(['blocked_at' => null])
            ->one();
    }

    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])
            ->andWhere(['blocked_at' => null])
            ->one();
    }

    public static function findByUsernameOrEmail($login)
    {
        return static::find()->where(['or', 'username = "' . $login . '"', 'email = "' . $login . '"'])
            ->andWhere(['blocked_at' => null])
            ->one();
    }
    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'blocked_at' => null
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = time();
        $this->password = $this->password == null ? $this->getModule()->defaultPassword : $this->password;
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }
    public function block()
    {
        return (bool)$this->updateAttributes([
            'blocked_at' => time(),
            'auth_key'   => \Yii::$app->security->generateRandomString(),
        ]);
    }

    /**
     * UnBlocks the user by setting 'blocked_at' field to null.
     */
    public function unblock()
    {
        return (bool)$this->updateAttributes(['blocked_at' => null]);
    }
    /**
     * Confirms the user by setting 'confirmed_at' field to current time.
     */
    public function confirm()
    {
        $result = (bool) $this->updateAttributes(['confirmed_at' => time()]);
        return $result;
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    public function getAvatar($width = 96, $height = 0)
    {
        if (empty($height)) {
            $height = $width;
        }
        if($this->profile->avatar) {
            $avatarFile = Yii::$app->storage->url2path($this->profile->avatar);
            $info = pathinfo($avatarFile);
            $thumbFile = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'] . '_' . $width . '_' . $height . '.' . $info['extension'];
            if (!is_file($thumbFile)) {
                Image::thumbnail($avatarFile, $width, $height, 'inset')->save($thumbFile);
            }
            return Yii::$app->storage->path2url($thumbFile);
        }
        return $this->getDefaultAvatar($width, $height);
    }
    public static  function getDefaultAvatar($width, $height)
    {
        list ($basePath, $baseUrl) = \Yii::$app->getAssetManager()->publish("@common/widgets/upload/assets/avatars");

        $name = "avatar_" . $width."x".$height. ".png";
        if(file_exists($basePath . DIRECTORY_SEPARATOR . $name))
        {
            return $baseUrl . "/" . $name;
        }
        return $baseUrl . "/" . "avatar_200x200.png";
    }
    public function saveAvatar($avatar)
    {
        $this->profile->avatar = $avatar;
        return $this->profile->save();
    }

    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this,'afterInsertInternal']);
    }
    public function afterInsertInternal($event)
    {
        $profile = new Profile();
        $profile->user_id = $event->sender->id;
        $profile->save();
    }

    /**
     * 是否管理员用户
     * @return bool
     */
    public function getIsAdmin()
    {
        return
            (\Yii::$app->getAuthManager() && $this->module->adminPermission ?
                \Yii::$app->user->can($this->module->adminPermission) : false)
            || in_array($this->username, $this->module->admins);
    }

    /**
     * @return bool Whether the user is confirmed or not.
     */
    public function getIsConfirmed()
    {
        return $this->confirmed_at != null;
    }

    /**
     * @return bool Whether the user is blocked or not.
     */
    public function getIsBlocked()
    {
        return $this->blocked_at != null;
    }

    /**
     * 今天是否已签到
     * @return bool
     */
    public function getIsSign()
    {
        if (!empty($this->sign)) {
            return date('Ymd', $this->sign->last_sign_at) == date('Ymd');
        }
        return false;
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSign()
    {
        return $this->hasOne(Sign::className(), ['user_id' => 'id']);
    }

    /**
     * TODO
     * @return string
     */
    public function getBadge()
    {
        return '土豪';
    }
}
