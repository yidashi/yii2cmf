<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/11
 * Time: 下午11:48
 */

namespace common\modules\attachment\components\flysystem;


use creocoder\flysystem\Filesystem;
use yii\base\InvalidConfigException;

class AliyuncsFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $access;
    /**
     * @var string
     */
    public $secret;
    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var bool
     */
    public $isCName = false;
    /**
     * @var string
     */
    public $bucket;
    /**
     * @var array
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->access === null) {
            throw new InvalidConfigException('The "access" property must be set.');
        }

        if ($this->secret === null) {
            throw new InvalidConfigException('The "secret" property must be set.');
        }

        if ($this->endpoint === null) {
            throw new InvalidConfigException('The "endpoint" property must be set.');
        }

        if ($this->bucket === null) {
            throw new InvalidConfigException('The "bucket" property must be set.');
        }

        parent::init();
    }

    /**
     * @return AliyuncsAdapter
     */
    protected function prepareAdapter()
    {
        return new AliyuncsAdapter(
            $this->access,
            $this->secret,
            $this->endpoint,
            $this->isCName,
            $this->bucket
        );
    }
}