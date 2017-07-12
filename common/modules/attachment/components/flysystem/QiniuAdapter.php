<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/11
 * Time: 下午11:44
 */

namespace common\modules\attachment\components\flysystem;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;
use Qiniu\Auth;
use Qiniu\Processing\ImageUrlBuilder;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class QiniuAdapter extends AbstractAdapter
{
    use NotSupportingVisibilityTrait;
    /**
     * @var \Qiniu\Storage\UploadManager
     */
    protected $uploadManager;
    /**
     * @var \Qiniu\Storage\BucketManager
     */
    protected $bucketManager;
    /**
     * @var string
     */
    protected $bucket;
    /**
     * @var string
     */
    protected $domain;
    /**
     * @var string
     */
    protected $token;
    /**
     * Constructor.
     */
    public function __construct($ak, $sk, $bucket, $domain)
    {
        $auth = new Auth($ak, $sk);
        $this->bucket = $bucket;
        $this->domain = $domain;
        $this->token = $auth->uploadToken($bucket);
        $this->uploadManager = new UploadManager();
        $this->bucketManager = new BucketManager($auth);
    }
    /**
     * {@inheritdoc}
     */
    public function write($path, $contents, Config $config)
    {
        list($ret, $error) = $this->uploadManager->put($this->token, $path, $contents);
        if ($error) {
            return false;
        }
        return $ret;
    }

    public function put($path, $contents, Config $config)
    {
        list($ret, $error) = $this->uploadManager->put($this->token, $path, $contents);
        if ($error) {
            return false;
        }
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function writeStream($path, $resource, Config $config)
    {
        list($ret, $error) = $this->uploadManager->put($this->token, $path, $resource);
        if ($error) {
            return false;
        }
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function putStream($path, $resource, Config $config)
    {
        list($ret, $error) = $this->uploadManager->put($this->token, $path, $resource);
        if ($error) {
            return false;
        }
        return $ret;
    }
    /**
     * {@inheritdoc}
     */
    public function update($path, $contents, Config $config)
    {
        $this->delete($path);
        return $this->write($path, $contents, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function updateStream($path, $resource, Config $config)
    {
        $this->delete($path);
        return $this->writeStream($path, $resource, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function rename($path, $newpath)
    {
        $r = $this->bucketManager->rename($this->bucket, $path, $newpath);
        return is_null($r);
    }
    public function copy($path, $newpath)
    {
        $r = $this->bucketManager->copy($this->bucket, $path, $this->bucket, $newpath);
        return is_null($r);
    }
    /**
     * {@inheritdoc}
     */
    public function delete($path)
    {
        return $this->bucketManager->delete($this->bucket, $path);
    }
    /**
     * {@inheritdoc}
     */
    public function deleteDir($dirname)
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function createDir($dirname, Config $config)
    {
        return ['path' => $dirname, 'type' => 'dir'];
    }
    /**
     * {@inheritdoc}
     */
    public function has($path)
    {
        $r = $this->bucketManager->stat($this->bucket, $path);
        return is_array($r[0]);
    }
    /**
     * {@inheritdoc}
     */
    public function read($path)
    {
        return false;
    }
    /**
     * {@inheritdoc}
     */
    public function readStream($path)
    {
        // @todo readStream;
        return false;
    }
    /**
     * {@inheritdoc}
     */
    public function listContents($directory = '', $recursive = false)
    {
        $list = [];
        $r = $this->bucketManager->listFiles($this->bucket, $directory);
        foreach ($r[0] as $v) {
            $list[] = $this->normalizeFileInfo($v);
        }
        return $list;
    }
    /**
     * {@inheritdoc}
     */
    public function getMetadata($path)
    {
        $r = $this->bucketManager->stat($this->bucket, $path);
        $r[0]['key'] = $path;
        return $this->normalizeFileInfo($r[0]);
    }
    /**
     * {@inheritdoc}
     */
    public function getSize($path)
    {
        return $this->getMetadata($path);
    }
    /**
     * {@inheritdoc}
     */
    public function getMimetype($path)
    {
        $r = $this->bucketManager->stat($this->bucket, $path);
        return ['mimetype' => $r[0]['mimeType']];
    }
    /**
     * {@inheritdoc}
     */
    public function getTimestamp($path)
    {
        return $this->getMetadata($path);
    }
    protected function normalizeFileInfo($filestat)
    {
        return array(
            'type' => 'file',
            'path' => $filestat['key'],
            'timestamp' => floor($filestat['putTime']/10000000),
            'size' => $filestat['fsize'],
        );
    }

    public function getUrl($path)
    {
        return $this->domain . '/' . $path;
    }

    public function thumbnail($path, $width, $height)
    {
        $imageBuilder = new ImageUrlBuilder();

        if (strpos($path, $this->domain . '/') !== false) {
            $path = substr($path, strlen($this->domain . '/'));
        }
        return $imageBuilder->thumbnail($this->domain . '/' . $path, 1, $width, $height);
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        if (strpos($path, $this->domain . '/') !== false) {
            $path = substr($path, strlen($this->domain . '/'));
        }
        return $this->domain . '/' . $path . '?imageMogr2/crop/!' . $width . 'x' . $height . 'a' . $start[0] . 'a' . $start[1];
    }

    public function water()
    {
        // TODO: Implement water() method.
    }
}