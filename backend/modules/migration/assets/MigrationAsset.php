<?php
namespace migration\assets;

class MigrationAsset extends  \yii\web\AssetBundle
{
    public $sourcePath = '@backend/modules/migration/static';
    public $css = [
        'migration.css',
    ];
    public $js = [
        'migration.js'
    ];
    public $depends = [
        '\backend\assets\AppAsset',
    ];
}