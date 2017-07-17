<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午5:49
 */

namespace common\modules\attachment\components;


use common\modules\attachment\components\contracts\Factory;
use common\modules\attachment\components\image\Processor;
use Yii;
use yii\base\Component;
use yii\base\Exception;

class FilesystemManager extends Component implements Factory
{
    public $defaultDriver;

    /**
     * The array of resolved filesystem drivers.
     *
     * @var array
     */
    public $disks = [];


    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return FilesystemAdapter
     */
    public function drive($name = null)
    {
        return $this->disk($name);
    }

    /**
     * Get a filesystem instance.
     *
     * @param  string  $name
     * @return FilesystemAdapter
     */
    public function disk($name = null)
    {
        $name = $name ?: $this->defaultDriver;

        return $this->disks[$name] = $this->get($name);
    }

    /**
     * @param $name
     * @return FilesystemAdapter
     * @throws Exception
     */
    protected function get($name)
    {
        if (isset($this->disks[$name])) {
            /**
             * @var  $filesystem
             */
            $filesystem = $this->disks[$name];
            if (!$filesystem instanceof FilesystemAdapter) {
                $filesystem = new FilesystemAdapter(Yii::createObject($this->disks[$name]));
            }
            return $filesystem;
        }
        throw new Exception('未定义的文件存储');
    }

    public function getPath($url)
    {
        return trim(str_replace($this->baseUrl, '', $url), '/');
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->disk(), $method], $parameters);
    }
}