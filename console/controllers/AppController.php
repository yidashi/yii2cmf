<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/6
 * Time: 下午3:35
 */

namespace console\controllers;


use yii\console\Controller;
use yii\db\Query;

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
        echo "\n  ... 应用构建成功.\n\n";
    }

    public function actionImport()
    {
        (new Query())->from('chncomic.destoon_article_23')->select('itemid,title,catid,introduce');
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

function copyFile($root, $source, $target, &$all, $params)
{
    if (!is_file($root . '/' . $source)) {
        echo "       skip $target ($source not exist)\n";
        return true;
    }
    if (is_file($root . '/' . $target)) {
        if (file_get_contents($root . '/' . $source) === file_get_contents($root . '/' . $target)) {
            echo "  unchanged $target\n";
            return true;
        }
        if ($all) {
            echo "  overwrite $target\n";
        } else {
            echo "      exist $target\n";
            echo "            ...overwrite? [Yes|No|All|Quit] ";


            $answer = !empty($params['overwrite']) ? $params['overwrite'] : trim(fgets(STDIN));
            if (!strncasecmp($answer, 'q', 1)) {
                return false;
            } else {
                if (!strncasecmp($answer, 'y', 1)) {
                    echo "  overwrite $target\n";
                } else {
                    if (!strncasecmp($answer, 'a', 1)) {
                        echo "  overwrite $target\n";
                        $all = true;
                    } else {
                        echo "       skip $target\n";
                        return true;
                    }
                }
            }
        }
        file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
        return true;
    }
    echo "   generate $target\n";
    @mkdir(dirname($root . '/' . $target), 0777, true);
    file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
    return true;
}

function getParams()
{
    $rawParams = [];
    if (isset($_SERVER['argv'])) {
        $rawParams = $_SERVER['argv'];
        array_shift($rawParams);
    }

    $params = [];
    foreach ($rawParams as $param) {
        if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
            $name = $matches[1];
            $params[$name] = isset($matches[3]) ? $matches[3] : true;
        } else {
            $params[] = $param;
        }
    }
    return $params;
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

function setCookieValidationKey($root, $paths)
{
    foreach ($paths as $file) {
        echo "   generate cookie validation key in $file\n";
        $file = $root . '/' . $file;
        $length = 32;
        $bytes = openssl_random_pseudo_bytes($length);
        $key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
        $content = preg_replace('/(("|\')cookieValidationKey("|\')\s*=>\s*)(""|\'\')/', "\\1'$key'", file_get_contents($file));
        file_put_contents($file, $content);
    }
}

function createSymlink($root, $links) {
    foreach ($links as $link => $target) {
        echo "      symlink " . $root . "/" . $target . " " . $root . "/" . $link . "\n";
        //first removing folders to avoid errors if the folder already exists
        @rmdir($root . "/" . $link);
        @symlink($root . "/" . $target, $root . "/" . $link);
    }
}