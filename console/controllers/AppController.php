<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/6
 * Time: 下午3:35
 */

namespace console\controllers;


use yii\console\Controller;
use Yii;
use yii\helpers\Console;

class AppController extends Controller
{
    public $defaultAction = 'install';

    public $writablePaths = [
        '@root/runtime',
        '@root/web/assets',
        '@root/web/admin/assets',
        '@root/web/storage'
    ];

    public $executablePaths = [
        '@root/yii',
    ];

    public $envPath = '@root/.env';

    public $installFile = '@root/web/storage/install.txt';

    public function actionSetWritable()
    {
        $this->setWritable($this->writablePaths);
    }

    public function actionSetExecutable()
    {
        $this->setExecutable($this->executablePaths);
    }

    public function actionSetKeys()
    {
        $this->setKeys($this->envPath);
    }

    public function setWritable($paths)
    {
        foreach ($paths as $writable) {
            $writable = Yii::getAlias($writable);
            Console::output("Setting writable: {$writable}");
            @chmod($writable, 0777);
        }
    }

    public function setExecutable($paths)
    {
        foreach ($paths as $executable) {
            $executable = Yii::getAlias($executable);
            Console::output("Setting executable: {$executable}");
            @chmod($executable, 0755);
        }
    }

    public function setKeys($file)
    {
        $file = Yii::getAlias($file);
        Console::output("Generating keys in {$file}");
        $content = file_get_contents($file);
        $content = preg_replace_callback('/<generated_key>/', function () {
            $length = 32;
            $bytes = openssl_random_pseudo_bytes(32, $cryptoStrong);
            return strtr(substr(base64_encode($bytes), 0, $length), '+/', '_-');
        }, $content);
        file_put_contents($file, $content);
    }

    public function actionSetDb()
    {
        do {
            $dbHost = $this->prompt('dbhost:', ['default' => '127.0.0.1']);
            $dbPort = $this->prompt('dbport:', ['default' => '3306']);
            $dbDbname = $this->prompt('dbname(auto create):', ['default' => 'yii']);
            $dbUsername = $this->prompt('dbusername:', ['default' => 'root']);
            $dbPassword = $this->prompt('dbpassword:');
            $dbDsn = "mysql:host={$dbHost};port={$dbPort}";
        } while(!$this->testConnect($dbDsn, $dbDbname, $dbUsername, $dbPassword));
        $dbDsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbDbname}";
        $dbTablePrefix = $this->prompt('tableprefix:', ['default' => 'yii2cmf_']);
        $this->setEnv('DB_USERNAME', $dbUsername);
        $this->setEnv('DB_PASSWORD', $dbPassword);
        $this->setEnv('DB_TABLE_PREFIX', $dbTablePrefix);
        $this->setEnv('DB_DSN', $dbDsn);
    }
    public function testConnect($dsn = '', $dbname, $username = '', $password = '')
    {
        try{
            $pdo = new \PDO($dsn, $username, $password);
            $sql = "CREATE DATABASE IF NOT EXISTS {$dbname}";
            $pdo->query($sql);
        } catch(\Exception $e) {
            $this->stderr("\n" . $e->getMessage(), Console::FG_RED);
            $this->stderr("\n  ... 连接失败,核对数据库信息.\n\n", Console::FG_RED, Console::BOLD);
            return false;
        }
        return true;
    }
    public function setEnv($name, $value)
    {
        $file = Yii::getAlias($this->envPath);
        $content = preg_replace("/({$name}\s*=)\s*(.*)/", "\\1$value", file_get_contents($file));
        file_put_contents($file, $content);
    }

    public function checkInstalled()
    {
        return file_exists(Yii::getAlias($this->installFile));
    }

    public function actionInstall()
    {
        if ($this->checkInstalled()) {
            $this->stdout("\n  ... 已经安装过.\n\n", Console::FG_RED);
            die;
        }
        copy(Yii::getAlias('@root/.env.example'), Yii::getAlias($this->envPath));
        $this->runAction('set-writable', ['interactive' => $this->interactive]);
        $this->runAction('set-executable', ['interactive' => $this->interactive]);
        $this->runAction('set-keys', ['interactive' => $this->interactive]);
        $this->runAction('set-db', ['interactive' => $this->interactive]);
        Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
        $appStatus = $this->select('设置当前应用模式', ['dev' => 'dev', 'prod' => 'prod']);
        $this->setEnv('YII_DEBUG', $appStatus == 'prod' ? 'false' : 'true');
        $this->setEnv('YII_ENV', $appStatus);
        file_put_contents(Yii::getAlias($this->installFile), time());
        $this->stdout("\n  ... 应用构建成功.\n\n", Console::FG_GREEN);
    }

    public function actionReset()
    {

    }

    public function actionUpdate()
    {
        \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
    }


}


