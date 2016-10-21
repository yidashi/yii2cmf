<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午5:49
 */

namespace common\components;


use yii\base\Component;

class Storage extends Component
{
    public $baseUrl;

    public $basePath;

    public function init()
    {
        parent::init();
        $this->baseUrl = \Yii::getAlias($this->baseUrl);
        $this->basePath = \Yii::getAlias($this->basePath);
    }

    public function path2url($path)
    {
        return str_replace($this->basePath, $this->baseUrl, $path);
    }
    public function url2path($url)
    {
        return str_replace($this->baseUrl, $this->basePath, $url);
    }
}