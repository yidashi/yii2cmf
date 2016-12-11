<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/13
 * Time: 上午10:51.
 */
namespace plugins\danmu;

use yii\helpers\Url;

class DanmuWidget extends \yii\base\Widget
{
    public $type;
    public $typeId;
    public $listUrl = null;
    public function init()
    {
        parent::init();
        $this->listUrl = $this->listUrl ?: Url::to(['/danmu/index']);
    }
    public function run()
    {
        DanmuAsset::register($this->view);
        $script = "initDm('{$this->type}', {$this->typeId}, '{$this->listUrl}');";
        $this->view->registerJs($script);
    }


}
