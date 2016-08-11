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
            $dbHost = $this->prompt('dbhost(默认为中括号内的值)' . PHP_EOL, ['default' => '127.0.0.1']);
            $dbPort = $this->prompt('dbport(默认为中括号内的值)' . PHP_EOL, ['default' => '3306']);
            $dbDbname = $this->prompt('dbname(不存在则自动创建)' . PHP_EOL, ['default' => 'yii']);
            $dbUsername = $this->prompt('dbusername(默认为中括号内的值)' . PHP_EOL, ['default' => 'root']);
            $dbPassword = $this->prompt('dbpassword' . PHP_EOL);
            $dbDsn = "mysql:host={$dbHost};port={$dbPort}";
        } while(!$this->testConnect($dbDsn, $dbDbname, $dbUsername, $dbPassword));
        $dbDsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbDbname}";
        $dbTablePrefix = $this->prompt('tableprefix(默认为中括号内的值)' . PHP_EOL, ['default' => 'yii2cmf_']);
        $this->setEnv('DB_USERNAME', $dbUsername);
        $this->setEnv('DB_PASSWORD', $dbPassword);
        $this->setEnv('DB_TABLE_PREFIX', $dbTablePrefix);
        $this->setEnv('DB_DSN', $dbDsn);
        Yii::$app->set('db', Yii::createObject([
                'class' => 'yii\db\Connection',
                'dsn' => $dbDsn,
                'username' => $dbUsername,
                'password' => $dbPassword,
                'tablePrefix' => $dbTablePrefix,
                'charset' => 'utf8'
            ])
        );
    }
    public function testConnect($dsn = '', $dbname, $username = '', $password = '')
    {
        try{
            $pdo = new \PDO($dsn, $username, $password);
            $sql = "CREATE DATABASE IF NOT EXISTS {$dbname} DEFAULT CHARSET utf8 COLLATE utf8_general_ci;";
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
        $start = <<<STR
+==========================================+
| Welcome to setup yii2cmf         |
| 欢迎使用 yii2cmf 安装程序     |
+------------------------------------------+
| Follow the on-screen instructions please |
| 请按照屏幕上的提示操作以完成安装         |
+==========================================+

STR;
        $this->stdout($start, Console::FG_GREEN);
        copy(Yii::getAlias('@root/.env.example'), Yii::getAlias($this->envPath));
        $this->runAction('set-writable', ['interactive' => $this->interactive]);
        $this->runAction('set-executable', ['interactive' => $this->interactive]);
        $this->runAction('set-keys', ['interactive' => $this->interactive]);
        $this->runAction('set-db', ['interactive' => $this->interactive]);
        $appStatus = $this->select('设置当前应用模式', ['dev' => 'dev', 'prod' => 'prod']);
        $this->setEnv('YII_DEBUG', $appStatus == 'prod' ? 'false' : 'true');
        $this->setEnv('YII_ENV', $appStatus);
        Yii::$app->runAction('migrate/up', ['interactive' => false]);
        Yii::$app->runAction('cache/flush-all', ['interactive' => false]);
        file_put_contents(Yii::getAlias($this->installFile), time());
        $end = <<<STR
+=================================================+
| Installation completed successfully, Thanks you |
| 安装成功，感谢选择和使用 yii2cmf              |
+-------------------------------------------------+
| 说明和注意事项：                                |
| 一些基本的设置可以在.env文件里修改
+=================================================+

STR;

        $this->stdout($end, Console::FG_GREEN);
    }

    public function actionReset()
    {
        @unlink(Yii::getAlias('@root/web/storage/install.txt'));
    }

    public function actionUpdate()
    {
        \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
    }


}


