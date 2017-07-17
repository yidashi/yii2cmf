<?php

namespace common\modules\attachment\components;

use common\modules\attachment\components\contracts\Cloud as CloudFilesystemContract;
use common\modules\attachment\components\contracts\FileNotFoundException as ContractFileNotFoundException;
use common\modules\attachment\components\contracts\Filesystem as FilesystemContract;
use common\modules\attachment\components\contracts\ImageProcessor as ImageContract;
use common\modules\attachment\components\flysystem\QiniuAdapter;
use creocoder\flysystem\Filesystem;
use InvalidArgumentException;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FileNotFoundException;
use RuntimeException;

class FilesystemAdapter implements FilesystemContract, CloudFilesystemContract, ImageContract
{
    /**
     * The Flysystem filesystem implementation.
     *
     * @var Filesystem
     */
    protected $driver;

    /**
     * Create a new filesystem adapter instance.
     *
     * @param  Filesystem  $driver
     */
    public function __construct(Filesystem $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Determine if a file exists.
     *
     * @param  string  $path
     * @return bool
     */
    public function exists($path)
    {
        return $this->driver->has($path);
    }

    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @return string
     *
     * @throws \common\modules\attachment\components\contracts\FileNotFoundException
     */
    public function get($path)
    {
        try {
            return $this->driver->read($path);
        } catch (FileNotFoundException $e) {
            throw new ContractFileNotFoundException($path, $e->getCode(), $e);
        }
    }

    /**
     * Write the contents of a file.
     *
     * @param  string  $path
     * @param  string|resource|UploadedFile  $contents
     * @param  array  $options
     * @return bool
     */
    public function put($path, $contents, $options = [])
    {
        if (is_string($options)) {
            $options = ['visibility' => $options];
        }

        // If the given contents is actually a file or uploaded file instance than we will
        // automatically store the file using a stream. This provides a convenient path
        // for the developer to store streams without managing them manually in code.
        if ($contents instanceof UploadedFile) {
            return $this->putFile($path, $contents, $options);
        }

        return is_resource($contents)
                ? $this->driver->putStream($path, $contents, $options)
                : $this->driver->put($path, $contents, $options);
    }

    /**
     * Store the uploaded file on the disk.
     *
     * @param  string  $path
     * @param  UploadedFile  $file
     * @param  array  $options
     * @return string|false
     */
    public function putFile($path, $file, $options = [])
    {
        return $this->putFileAs($path, $file, $file->getHashName(), $options);
    }

    /**
     * Store the uploaded file on the disk with a given name.
     *
     * @param  string  $path
     * @param  UploadedFile  $file
     * @param  string  $name
     * @param  array  $options
     * @return string|false
     */
    public function putFileAs($path, $file, $name, $options = [])
    {
//        $stream = fopen($file->tempName, 'r+');
        $stream = file_get_contents($file->tempName);
        // Next, we will format the path of the file and store the file using a stream since
        // they provide better performance than alternatives. Once we write the file this
        // stream will get closed automatically by us so the developer doesn't have to.
        $result = $this->put(
            $path = trim($path.'/'.$name, '/'), $stream, $options
        );

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $result ? $path : false;
    }

    /**
     * Get the visibility for the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function getVisibility($path)
    {
        if ($this->driver->getVisibility($path) == AdapterInterface::VISIBILITY_PUBLIC) {
            return FilesystemContract::VISIBILITY_PUBLIC;
        }

        return FilesystemContract::VISIBILITY_PRIVATE;
    }

    /**
     * Set the visibility for the given path.
     *
     * @param  string  $path
     * @param  string  $visibility
     * @return void
     */
    public function setVisibility($path, $visibility)
    {
        return $this->driver->setVisibility($path, $this->parseVisibility($visibility));
    }

    /**
     * Prepend to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @param  string  $separator
     * @return int
     */
    public function prepend($path, $data, $separator = PHP_EOL)
    {
        if ($this->exists($path)) {
            return $this->put($path, $data.$separator.$this->get($path));
        }

        return $this->put($path, $data);
    }

    /**
     * Append to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @param  string  $separator
     * @return int
     */
    public function append($path, $data, $separator = PHP_EOL)
    {
        if ($this->exists($path)) {
            return $this->put($path, $this->get($path).$separator.$data);
        }

        return $this->put($path, $data);
    }

    /**
     * Delete the file at a given path.
     *
     * @param  string|array  $paths
     * @return bool
     */
    public function delete($paths)
    {
        $paths = is_array($paths) ? $paths : func_get_args();

        $success = true;

        foreach ($paths as $path) {
            try {
                if (! $this->driver->delete($path)) {
                    $success = false;
                }
            } catch (FileNotFoundException $e) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Copy a file to a new location.
     *
     * @param  string  $from
     * @param  string  $to
     * @return bool
     */
    public function copy($from, $to)
    {
        return $this->driver->copy($from, $to);
    }

    /**
     * Move a file to a new location.
     *
     * @param  string  $from
     * @param  string  $to
     * @return bool
     */
    public function move($from, $to)
    {
        return $this->driver->rename($from, $to);
    }

    /**
     * Get the file size of a given file.
     *
     * @param  string  $path
     * @return int
     */
    public function size($path)
    {
        return $this->driver->getSize($path);
    }

    /**
     * Get the mime-type of a given file.
     *
     * @param  string  $path
     * @return string|false
     */
    public function mimeType($path)
    {
        return $this->driver->getMimetype($path);
    }

    /**
     * Get the file's last modification time.
     *
     * @param  string  $path
     * @return int
     */
    public function lastModified($path)
    {
        return $this->driver->getTimestamp($path);
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function getUrl($path)
    {
        $adapter = $this->driver->getAdapter();

        if (method_exists($adapter, 'getUrl')) {
            return $adapter->getUrl($path);
        } elseif ($adapter instanceof QiniuAdapter) {
            return $this->getQiniuUrl($adapter, $path);
        } elseif ($adapter instanceof LocalAdapter) {
            return $this->getLocalUrl($path);
        } else {
            throw new RuntimeException('This driver does not support retrieving URLs.');
        }
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param  QiniuAdapter  $adapter
     * @param  string  $path
     * @return string
     */
    protected function getQiniuUrl($adapter, $path)
    {
        return $adapter->getUrl($path);
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getLocalUrl($path)
    {
        $url = $this->driver->url;
        return rtrim($url, '/').'/'.ltrim($path, '/');

    }

    public function thumbnail($path, $width, $height)
    {
        $adapter = $this->driver->getAdapter();

        if (method_exists($adapter, 'thumbnail')) {
            try {
                return $adapter->thumbnail($path, $width, $height);
            } catch(\Exception $e) {
                return $path;
            }
        } else {
            throw new RuntimeException('This driver does not support thumbnail');
        }
    }

    public function crop($path, $width, $height, array $start = [0, 0])
    {
        $adapter = $this->driver->getAdapter();

        if (method_exists($adapter, 'crop')) {
            try {
                return $adapter->crop($path, $width, $height, $start);
            } catch(\Exception $e) {
                return $path;
            }
        } else {
            throw new RuntimeException('This driver does not support crop');
        }
    }

    /**
     * Create a directory.
     *
     * @param  string  $path
     * @return bool
     */
    public function makeDirectory($path)
    {
        return $this->driver->createDir($path);
    }

    /**
     * Recursively delete a directory.
     *
     * @param  string  $directory
     * @return bool
     */
    public function deleteDirectory($directory)
    {
        return $this->driver->deleteDir($directory);
    }

    /**
     * Get the Flysystem driver.
     *
     * @return Filesystem
     */
    public function getDriver()
    {
        return $this->driver;
    }


    /**
     * Parse the given visibility value.
     *
     * @param  string|null  $visibility
     * @return string|null
     *
     * @throws \InvalidArgumentException
     */
    protected function parseVisibility($visibility)
    {
        if (is_null($visibility)) {
            return;
        }

        switch ($visibility) {
            case FilesystemContract::VISIBILITY_PUBLIC:
                return AdapterInterface::VISIBILITY_PUBLIC;
            case FilesystemContract::VISIBILITY_PRIVATE:
                return AdapterInterface::VISIBILITY_PRIVATE;
        }

        throw new InvalidArgumentException('Unknown visibility: '.$visibility);
    }

    /**
     * Pass dynamic methods call onto Flysystem.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array([$this->driver, $method], $parameters);
    }
}
