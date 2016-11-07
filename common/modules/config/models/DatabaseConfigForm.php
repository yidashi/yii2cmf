<?php
namespace config\models;

use config\helpers\Dsn;
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
            [
                [
                    'hostname',
                    'username',
                    'database'
                ],
                'required'
            ],
            [
                [
                    'hostname',
                    'username',
                    'database',
                    "password"
                ],
                'checkDb'
            ]
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
            'hostname' => 'Hostname',
            'username' => 'Username',
            'password' => 'Password',
            'database' => 'Name of Database'
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
        $config->setEnv('DB_DSN', "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=3306");
        $config->setEnv('DB_USERNAME', $this->username);
        $config->setEnv('DB_PASSWORD', $this->password);

        return true;
    }
}