<?php
namespace common\modules\config\models;

use common\helpers\Dsn;
use yii\base\Model;
use yii\db\Connection;
use yii\db\Exception;
use Yii;

class DatabaseConfigForm extends Model
{
    use ConfigTrait;

    public $hostname;

    public $username;

    public $password;

    public $database;

    public function rules()
    {
        return [
            [['hostname', 'username', 'database'], 'required'],
            [['hostname', 'username', 'database', 'password'], 'checkDb']
        ];
    }

    public function checkDb($attribute, $params)
    {
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->database;
        // Create Test DB Connection
        Yii::$app->set('newDb', [
            'class' => Connection::className(),
            'dsn' => $dsn,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8'
        ]);

        try {

            Yii::$app->get("newDb")->open();
        } catch (Exception $e) {

            switch ($e->getCode()) {
                case 1049:
                    $this->addError("database", $e->getMessage());
                    break;
                case 1045:
                    $this->addError("password", $e->getMessage());
                    break;
                case 2002:
                    $this->addError("hostname", $e->getMessage());
                    break;
                default:
                    $this->addError("hostname", $e->getMessage());
                    break;
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'hostname' => '数据库地址',
            'username' => '数据库用户名',
            'password' => '数据库密码',
            'database' => '数据库名字'
        ];
    }

    public function loadDefaultValues()
    {
        $db = \Yii::$app->getDb();
        $dsn = Dsn::parse($db->dsn);
        $this->hostname = $dsn->host;
        $this->database = $dsn->database;
        $this->username = $db->username;
        $this->password = $db->password;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }

        $config = $this->getConfig();
        $config->set('DB_DSN', "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=3306");
        $config->set('DB_USERNAME', $this->username);
        $config->set('DB_PASSWORD', $this->password);

        return true;
    }

    // 不用env的用这个方法
    public function save2($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }

        $config = $this->getConfig();
        $db = [];
        $db['class'] = 'yii\db\Connection';
        $db['dsn'] = "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=3306";
        $db['username'] = $this->username;
        $db['password'] = $this->password;
        $localConfig = $config->getConfigFromLocal();
        $localConfig['components']['db'] = $db;
        $config->setConfigToLocal($localConfig);
        Yii::$app->set('db', $db);
        return true;
    }
}