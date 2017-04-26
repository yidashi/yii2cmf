<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/6
 * Time: 下午3:35
 */

namespace console\controllers;


use common\modules\user\models\User;
use yii\console\Controller;
use Yii;
use yii\helpers\Console;

class AppController extends Controller
{
    public $defaultAction = 'install';

    public $writablePaths = [
        '@root/web/assets',
        '@root/web/admin/assets',
        '@root/web/storage',
        '@root/cache',
        '@api/runtime',
        '@backend/runtime',
        '@frontend/runtime',
        '@wechat/runtime',
    ];

    public $executablePaths = [
        '@root/yii',
    ];

    public $envPath = '@root/.env';

    public $installFile = '@root/web/storage/install.txt';

    /**
     * 设置可写
     */
    public function actionSetWritable()
    {
        $this->setWritable($this->writablePaths);
    }

    /**
     * 设置可执行
     */
    public function actionSetExecutable()
    {
        $this->setExecutable($this->executablePaths);
    }

    /**
     * 设置cookie加密key
     */
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

    /**
     * 设置数据库
     * @throws \yii\base\InvalidConfigException
     */
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
        $content = preg_replace("/({$name}\s*=)\s*(.*)/", "\${1}$value", file_get_contents($file));// \${1}修复后边跟数字的bug
        file_put_contents($file, $content);
    }

    public function checkInstalled()
    {
        return file_exists(Yii::getAlias($this->installFile));
    }

    public function setInstalled()
    {
        file_put_contents(Yii::getAlias($this->installFile), time());
    }
    // 重置安装
    public function resetInstall()
    {
        $this->run('/migrate/down', ['all', 'interactive' => false]);
        @unlink(Yii::getAlias($this->installFile));
        @unlink(Yii::getAlias($this->envPath));
    }
    // 安装
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
        // 迁移
        Yii::$app->runAction('migrate/up', ['interactive' => false]);
        //创建默认用户
        $this->runAction('create-admin', ['interactive' => $this->interactive]);
        $this->setEnv('SITE_URL', $this->prompt('siteUrl'));
        // 清缓存
        Yii::$app->runAction('cache/flush-all', ['interactive' => false]);
        $this->setInstalled();
        $end = <<<STR
+=================================================+
| Installation completed successfully, Thanks you |
| 安装成功，感谢选择和使用 yii2cmf              |
+------------------------------------------+
| 默认后台账号：hehe  密码： 111111
+=================================================+

STR;

        $this->stdout($end, Console::FG_GREEN);
    }

    public function actionCreateAdmin()
    {
        $user = new User();
        $user->setScenario("create");
        $user->email = 'hehe@hehe.com';
        $user->username = 'hehe';
        $user->password = '111111';
        $user->create();
    }
    public function actionReset()
    {
        if (!$this->checkInstalled()) {
            $this->stdout("\n  ... 还没安装.\n\n", Console::FG_RED);
            die;
        }
        if ($this->confirm('确定要重置安装状态吗？')) {
            $this->resetInstall();
        }
    }

    public function actionUpdate()
    {
        \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
    }

}


