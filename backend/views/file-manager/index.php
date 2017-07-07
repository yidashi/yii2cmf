<?php
/* @var $this yii\web\View */
$this->title = '文件管理';
?>

<div class="row">
    <div class="col-xs-12">
        <?php echo \mihaildev\elfinder\ElFinder::widget([
            'controller'       => 'file-manager-elfinder',
            'frameOptions' => ['style'=>'min-height: 500px; width: 100%; border: 0'],
            ]);
        ?>
    </div>
</div>
