<?php


/* @var $this yii\web\View */

$this->title = '新区域';
$this->params['breadcrumbs'][] = ['label' => '区域', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加新区域';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>

