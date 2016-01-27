<?php

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/13
 * Time: 上午10:51.
 */
namespace common\widgets\danmu;

use yii\helpers\Url;

class Danmu extends \yii\base\Widget
{
    public $id;
    public $listUrl = null;
    public function init()
    {
        parent::init();
        $this->listUrl = $this->listUrl ?: Url::to(['/comment/dm']);
    }
    public function run()
    {
        DanmuAsset::register($this->view);
        $script = "initDm({$this->id}, '{$this->listUrl}');";
        $this->view->registerJs($script);
    }
}
