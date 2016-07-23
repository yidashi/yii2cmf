<?php
namespace backend\widgets\grid;

class SwitcherAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/widgets/grid/assets';

    public function init()
    {
        $this->js[] = 'switchery.min.js';
        $this->css[] = 'switchery.min.css';
    }
}