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
use League\Flysystem\Config;
use OSS\OssClient;

class AliyuncsAdapter extends AbstractAdapter
{
    use NotSupportingVisibilityTrait;

    protected $ossClient;
    /**
     * @var string
     */
    protected $bucket;
    /**
     * @var string
     */
    protected $token;
    /**
     * Constructor.
     */
    public function __construct($ak, $sk, $endpoint, $isCName, $bucket)
    {
        $this->ossClient = new OssClient($ak, $sk, $endpoint, $isCName);
        $this->bucket = $bucket;
    }
    /**
     * {@inheritdoc}
     */
    public function write($path, $contents, Config $config)
    {
        return $this->ossClient->putObject($this->bucket, $path, $contents);
    }
    /**
     * {@inheritdoc}
     */
    public function writeStream($path, $resource, Config $config)
    {
        // @todo Sharding Upload
        return false;
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
        return false;
    }
    public function copy($path, $newpath)
    {
        $r = $this->ossClient->copyObject($this->bucket, $path, $this->bucket, $newpath);
        return is_null($r);
    }
    /**
     * {@inheritdoc}
     */
    public function delete($path)
    {
        $r = $this->ossClient->deleteObject($this->bucket, $path);
        return is_null($r);
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
        return $this->ossClient->doesObjectExist($this->bucket, $path);
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
        $r = $this->ossClient->listObjects($this->bucket, $directory);
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
        $r = $this->ossClient->getObjectMeta($this->bucket, $path);
        $r['key'] = $path;
        return $this->normalizeFileInfo($r);
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
        $r = $this->ossClient->getObjectMeta($this->bucket, $path);
        return ['mimetype' => $r['content-type']];
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
            'timestamp' => $filestat['last-modified'],
            'size' => $filestat['content-length'],
        );
    }

    public function getThumb()
    {

    }
}