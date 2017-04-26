<?php
namespace migration\assets;

class MigrationAsset extends  \yii\web\AssetBundle
{
    public $css = [
        'migration.css',
    ];
    public $js = [
        'migration.js'
    ];
    public $depends = [
        '\backend\assets\AppAsset',
    ];

    public function init()
    {
        parent::init();
        $this->sourcePath = dirname(__DIR__) . '/static';
    }
}