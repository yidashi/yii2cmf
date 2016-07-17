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
    public $writAblePaths = [
        'runtime',
        'web/assets',
        'web/admin/assets',
        'web/static'
    ];
    public function actionIndex()
    {

        if (!extension_loaded('openssl')) {
            die('The OpenSSL PHP extension is required by Yii2.');
        }
        $root = str_replace('\\', '/', dirname(dirname(__DIR__)));
        setWritable($root, $this->writAblePaths);
        $envFile = $root . '/.env';
        if (is_file($envFile) && !$this->confirm('系统已经安装,是否要重置?')) {
            die;
        }
        do {
            $dbHost = $this->prompt('数据库地址:', ['default' => '127.0.0.1']);
            $dbPort = $this->prompt('数据库端口:', ['default' => '3306']);
            $dbDbname = $this->prompt('数据库库名(不存在则自动创建):', ['default' => 'yii']);
            $dbUsername = $this->prompt('数据库帐号:', ['default' => 'root']);
            $dbPassword = $this->prompt('数据库密码:', ['default' => 'root']);
            $dbDsn = "mysql:host={$dbHost};port={$dbPort}";
        } while(!$this->testConnect($dbDsn, $dbDbname, $dbUsername, $dbPassword));
        $dbDsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbDbname}";
        $dbTablePrefix = $this->prompt('数据库表前缀:', ['default' => 'pop_']);
        copy($root . '/.env.example', $envFile);
        setEnv('DB_USERNAME', $dbUsername);
        setEnv('DB_PASSWORD', $dbPassword);
        setEnv('DB_TABLE_PREFIX', $dbTablePrefix);
        setEnv('DB_DSN', $dbDsn);
        setEnv('FRONTEND_COOKIE_VALIDATION_KEY', generateCookieValidationKey());
        setEnv('BACKEND_COOKIE_VALIDATION_KEY', generateCookieValidationKey());
        $this->command('migrate --interactive=0');
        $appStatus = $this->select('当前应用模式', ['dev' => 'dev', 'prod' => 'prod']);
        setEnv('YII_DEBUG', $appStatus == 'prod' ? 'false' : 'true');
        setEnv('YII_ENV', $appStatus);
        $this->stdout("\n  ... 应用构建成功.\n\n", Console::FG_GREEN);
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
    public function command($cmd)
    {
        $yii = str_replace('\\', '/', dirname(dirname(__DIR__))) . '/yii';
        $cmd = PHP_BINDIR . '/php ' . $yii . ' ' . $cmd;
        if ($this->isWindows() === true) {
            pclose(popen('start /b ' . $cmd, 'r'));
        } else {
            pclose(popen($cmd . ' > /dev/null &', 'r'));
        }
        return true;
    }
    /**
     * Check operating system
     *
     * @return boolean true if it's Windows OS
     */
    protected function isWindows()
    {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            return true;
        } else {
            return false;
        }
    }
}
function getFileList($root, $basePath = '')
{
    $files = [];
    $handle = opendir($root);
    while (($path = readdir($handle)) !== false) {
        if ($path === '.svn' || $path === '.' || $path === '..') {
            continue;
        }
        $fullPath = "$root/$path";
        $relativePath = $basePath === '' ? $path : "$basePath/$path";
        if (is_dir($fullPath)) {
            $files = array_merge($files, getFileList($fullPath, $relativePath));
        } else {
            $files[] = $relativePath;
        }
    }
    closedir($handle);
    return $files;
}

function setEnv($name, $value)
{
    $root = str_replace('\\', '/', dirname(dirname(__DIR__)));
    $file = $root . '/.env';
    $content = preg_replace("/({$name}\s*=)\s*(.*)/", "\\1$value", file_get_contents($file));
    file_put_contents($file, $content);
}


function setWritable($root, $paths)
{
    foreach ($paths as $writable) {
        echo "      chmod 0777 $writable\n";
        chmod("$root/$writable", 0777);
    }
}

function setExecutable($root, $paths)
{
    foreach ($paths as $executable) {
        echo "      chmod 0755 $executable\n";
        @chmod("$root/$executable", 0755);
    }
}

function generateCookieValidationKey()
{
    $length = 32;
    $bytes = openssl_random_pseudo_bytes($length);
    $key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
    return $key;
}

function createSymlink($root, $links) {
    foreach ($links as $link => $target) {
        echo "      symlink " . $root . "/" . $target . " " . $root . "/" . $link . "\n";
        //first removing folders to avoid errors if the folder already exists
        @rmdir($root . "/" . $link);
        @symlink($root . "/" . $target, $root . "/" . $link);
    }
}