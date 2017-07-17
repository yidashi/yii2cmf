<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/12 21:56
 * Description:
 */

namespace common\modules\attachment\components\flysystem;


class LocalFilesystem extends \creocoder\flysystem\LocalFilesystem
{
    public $url;

    public function init()
    {
        parent::init();
        $this->url = \Yii::getAlias($this->url);
    }

    protected function prepareAdapter()
    {
        return new LocalAdapter($this->path, $this->url);
    }
}